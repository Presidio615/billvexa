<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        
        $query = Transaction::with('user');

        // Search Transaction ID
        if ($request->filled('search')) {
            $query->where('reference', 'like', '%' . $request->search . '%');
        }

        // Filter Status
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter Service
        if ($request->filled('service')) {
            $query->where('service', $request->service);
        }

        // Filter Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query
        ->latest()
        ->paginate(5);

        return view('admin.transactions', [

            'transactions' => $transactions,

            'totalTransactions' => Transaction::count(),

            'successfulTransactions' =>
                Transaction::where('status', 'successful')->count(),

            'pendingTransactions' =>
                Transaction::where('status', 'pending')->count(),

            'failedTransactions' =>
                Transaction::whereIn('status', ['failed', 'refunded'])->count(),
        ]);

        
    }

    public function show(Transaction $transaction)
    {
        return view('admin.transaction-view', compact('transaction'));
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'approved') {
            return back()->with('error', 'Only successful transactions can be approved.');
        }
        
        $transaction->update([
            'status' => 'successful'
        ]);

        return back()->with('success', 'Transaction approved successfully.');
    }

    public function reverse(Transaction $transaction)
    {
        if ($transaction->status !== 'reversed') {
            return back()->with('error', 'Only successful transactions can be reverse.');
        }
        
        
        $transaction->update([
            'status' => 'reversed'
        ]);

        return back()->with('success', 'Transaction reversed successfully.');
    }

    public function refund(Transaction $transaction)
    {
        if ($transaction->status !== 'refounded') {
            return back()->with('error', 'Only successful transactions can be refunded.');
        }
        // Update transaction
        $transaction->update([
            'status' => 'refunded'
        ]);
    
        // Notify the user
        Notification::create([
            'user_id' => $transaction->user_id,
            'title' => 'Transaction Refunded',
            'message' => '₦' . number_format($transaction->amount, 2) . ' has been refunded to your wallet.',
            'link' => route('history'),
        ]);
    
        // Notify the admin dashboard
        AdminNotification::create([
            'admin_id' => auth('admin')->id(), // optional but recommended
            'title' => 'Transaction Refunded',
            'message' => auth('admin')->user()->name .
                         ' refunded ₦' .
                         number_format($transaction->amount, 2) .
                         ' to ' . $transaction->user->name,
            'link' => route('admin.transaction.show', $transaction),
        ]);
    
        return back()->with('success', 'Transaction refunded successfully.');
    }
    

}
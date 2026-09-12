<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TransactionStatusMail;
use App\Models\AdminNotification;
use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        return view('admin.transaction', [

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
   
    public function exportTransactions(Request $request)
    {
        $type = $request->get('type', 'all');
    
        $data = Transaction::with('user')
            ->latest()
            ->get()
            ->map(function ($transaction) {
                return [
                    'Reference' => $transaction->reference,
                    'User' => $transaction->user?->name ?? 'N/A',
                    'Email' => $transaction->user?->email ?? 'N/A',
                    'Service' => $transaction->service,
                    'Network' => $transaction->network,
                    'Phone' => $transaction->phone,
                    'Amount' => $transaction->amount,
                    'Discount' => $transaction->discount,
                    'Profit' => $transaction->profit,
                    'Total' => $transaction->total,
                    'Status' => $transaction->status,
                    'Date' => $transaction->created_at?->format('d M Y, h:i A'),
                ];
            });
    
        $setting = \App\Models\Setting::first();
    
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Admin.exports', [
            'type' => $type,
            'data' => $data,
            'setting' => $setting,
        ]);
    
        $pdf->setPaper('a4', 'landscape');
    
        return $pdf->download(
            'BillVexa-transactions-' . now()->format('Y-m-d') . '.pdf'
        );
    }
    
    
    

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Only pending transactions can be approved.');
        }
    
        $transaction->update([
            'status' => 'successful',
        ]);
    
        Notification::create([
            'user_id' => $transaction->user_id,
            'title' => 'Transaction Approved',
            'message' => 'Your ₦' . number_format($transaction->total, 2) .
                         ' ' . $transaction->service .
                         ' transaction has been approved successfully.',
            'link' => route('history'),
        ]);

        // Email notification to user
        if ($transaction->user && $transaction->user->email) {
            Mail::to($transaction->user->email)
                ->send(new TransactionStatusMail(
                    $transaction,
                    'approved'
                ));
        }
    
        AdminNotification::create([
            'admin_id' => auth('admin')->id(),
            'recipient_type' => 'admin',
            'title' => 'Transaction Approved',
            'message' => auth('admin')->user()->name .
                         ' approved a ₦' .
                         number_format($transaction->total, 2) .
                         ' ' . $transaction->service .
                         ' transaction.',
            'link' => route('admin.transaction.show', $transaction),
        ]);
    
        return back()->with('success', 'Transaction approved successfully.');
    }

    public function reverse(Transaction $transaction)
    {
        if ($transaction->status !== 'successful') {
            return back()->with('error', 'Only successful transactions can be reverse.');
        }
        
        
        $transaction->update([
            'status' => 'reversed'
        ]);

        Notification::create([
            'user_id' => $transaction->user_id,
            'title' => 'Transaction Reversed',
            'message' => 'Your ₦' . number_format($transaction->total, 2) .
                         ' ' . $transaction->service .
                         ' transaction has been reversed successfully.',
            'link' => route('history'),
        ]);

        // Email notification
        if ($transaction->user && $transaction->user->email) {
            Mail::to($transaction->user->email)
                ->send(new TransactionStatusMail(
                    $transaction,
                    'reversed'
                ));
        }

        AdminNotification::create([
            'admin_id' => auth('admin')->id(),
            'recipient_type' => 'admin',
            'title' => 'Transaction Reversed',
            'message' => auth('admin')->user()->name .
                         ' reversed a ₦' .
                         number_format($transaction->total, 2) .
                         ' ' . $transaction->service .
                         ' transaction.',
            'link' => route('admin.transaction.show', $transaction),
        ]);

        return back()->with('success', 'Transaction reversed successfully.');
    }

    public function refund(Transaction $transaction)
    {
        if ($transaction->status !== 'successful') {
            return back()->with(
                'error',
                'Only successful transactions can be refunded.'
            );
        }
    
        DB::transaction(function () use ($transaction) {
    
            $user = \App\Models\User::lockForUpdate()
                ->find($transaction->user_id);
    
            if (!$user) {
                throw new \RuntimeException('User not found.');
            }
    
            // Return money to wallet
            $user->increment(
                'wallet_balance',
                $transaction->total
            );
    
            // Mark transaction as refunded
            $transaction->update([
                'status' => 'refunded',
            ]);
    
            // In-app notification
            Notification::create([
                'user_id' => $transaction->user_id,
                'title' => 'Transaction Refunded',
                'message' => '₦' .
                             number_format($transaction->total, 2) .
                             ' has been refunded to your wallet for your ' .
                             $transaction->service .
                             ' transaction.',
                'link' => route('history'),
            ]);
    
            // Email notification
            if ($user->email) {
                Mail::to($user->email)
                    ->send(new TransactionStatusMail(
                        $transaction,
                        'refunded'
                    ));
            }
    
            // Admin notification
            AdminNotification::create([
                'admin_id' => auth('admin')->id(),
                'recipient_type' => 'admin',
                'title' => 'Transaction Refunded',
                'message' => 'BillVexa Admin refunded ₦' .
                             number_format($transaction->total, 2) .
                             ' to the user for a ' .
                             $transaction->service .
                             ' transaction.',
                'link' => route(
                    'admin.transaction.show',
                    $transaction
                ),
            ]);
        });
    
        return back()->with(
            'success',
            'Transaction refunded successfully.'
        );
    }

}
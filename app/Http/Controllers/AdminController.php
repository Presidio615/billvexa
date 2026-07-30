<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Deposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminNotification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function login()
    {
        return view('admin.auth.login');
    }
    public function logs()
    {
        return view('admin.logs');
    }
    public function logout()
    {
        return view('admin.login');
    }

        public function createUser()
    {
        return view('admin.user-create');
    }

    public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'password' => 'required|min:8',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'wallet_balance' => 0,
    ]);

    return redirect()
        ->route('admin.user')
        ->with('success', 'User created successfully.');
}   

    


    public function users(Request $request)
    {
        $query = User::query();
    
        // Search
        if ($request->filled('search')) {
    
            $search = $request->search;
    
            $query->where(function ($q) use ($search) {
    
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
    
            });
        }
    
        // KYC Filter
        if ($request->filled('status')) {
    
            switch ($request->status) {
    
                case 'verified':
                    $query->where('kyc_verified', true);
                    break;
    
                case 'pending':
                    $query->where('kyc_verified', false);
                    break;
            }
        }
    
        // Wallet Filter
        if ($request->filled('wallet')) {
    
            switch ($request->wallet) {
    
                case 'high':
                    $query->where('wallet_balance', '>=', 100000);
                    break;
    
                case 'low':
                    $query->where('wallet_balance', '<=', 10000);
                    break;
            }
        }
    
        $users = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    
            $stats = [

                'total'      => User::count(),
                'verified' => User::where('nin_status', 'approved')->count(),
                'pending' => User::where('nin_status', 'pending')->count(),
                'rejected' => User::where('nin_status', 'rejected')->count(),

                // You don't have a status column yet
                'suspended'  => 0,
        
            ];
        return view('admin.user', compact('users', 'stats'));
    }

    // Show edit form
public function editUser(User $user)
{
    return view('admin.user-edit', compact('user'));
}

// Update user
public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
    ]);

    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    return redirect()
        ->route('admin.user')
        ->with('success', 'User updated successfully.');
}



public function showUser(User $user)
{
    return view('admin.user.show', compact('user'));
}

public function deleteUser(User $user)
{
    $user->delete();

    return redirect()
        ->route('admin.user')
        ->with('success', 'User deleted successfully.');
}


    
public function transactions(Request $request)
{
    $query = Transaction::with('user');

    if ($request->filled('search')) {
        $query->where('reference', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('status') && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    if ($request->filled('service')) {
        $query->where('service', $request->service);
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $transactions = $query->latest()->paginate(15);

    return view('admin.transaction', [

        'transactions' => $transactions,

        'totalTransactions' => Transaction::count(),

        'successfulTransactions' => Transaction::where('status', 'successful')->count(),

        'pendingTransactions' => Transaction::where('status', 'pending')->count(),

        'failedTransactions' => Transaction::whereIn('status', ['failed', 'refunded'])->count(),
        'refundedTransactions' => Transaction::where('status', 'refunded')->count(),

    ]);
}

public function exportTransactions()
{
    return Excel::download(new TransactionsExport, 'transactions.xlsx');
}

public function showTransaction(Transaction $transaction)
{
    $transaction->load('user');

    return view('admin.transaction-view', compact('transaction'));
}

public function approveTransaction(Transaction $transaction)
{
    // Only pending transactions can be approved
    if ($transaction->status !== 'pending') {

        return back()->with(
            'error',
            "This transaction is already {$transaction->status}."
        );
    }

    DB::transaction(function () use ($transaction) {

        $transaction->update([
            'status'      => 'successful',
            'approved_by' => Auth::guard('admin')->id(),
            'approved_at' => now(),
        ]);

    });

    // Notify the admin dashboard
    AdminNotification::create([
        'admin_id' => auth('admin')->id(),
        'title' => 'Transaction Approved',
        'message' => auth('admin')->user()->name .
                    ' approved transaction ' .
                    $transaction->reference,
        'link' => route('admin.transaction.show', $transaction),
    ]);

    return back()->with(
        'success',
        'Transaction approved successfully.'
    );
}

public function reverseTransaction(Transaction $transaction)
{
    if ($transaction->status != 'successful') {
        return back()->with('error', 'Only successful transactions can be reversed.');
    }

    DB::transaction(function () use ($transaction) {

        $user = $transaction->user;
        
        // Credit wallet
        $user->wallet_balance += $transaction->amount;

        $user->save();
        
        // Update transaction
        $transaction->update([
            'status' => 'reversed',
        ]);


        // Notify the admin dashboard
        AdminNotification::create([
            'admin_id' => auth('admin')->id(),
            'title' => 'Transaction Reversed',
            'message' => auth('admin')->user()->name .
                         ' reversed transaction ' .
                         $transaction->reference,
            'link' => route('admin.transaction.show', $transaction),
        ]);

    });

    return back()->with('success', 'Transaction reversed successfully. User wallet has been credited.');
}

public function refundTransaction(Transaction $transaction)
{
    if ($transaction->status != 'successful') {
        return back()->with('error', 'Only successful transactions can be refunded.');
    }

    DB::transaction(function () use ($transaction) {

        $user = $transaction->user;
            
        // Credit wallet
        $user->wallet_balance += $transaction->amount;

        $user->save();
        
        // Update transaction
        $transaction->update([
            'status' => 'refunded',
        ]);


        
        // Notify the admin dashboard
        AdminNotification::create([
            'admin_id' => auth('admin')->id(), // optional but recommended
            'title' => 'Refund Processed',
            'message' => auth('admin')->user()->name .
                         ' refunded ₦' .
                         number_format($transaction->amount, 2) .
                         ' to ' . $transaction->user->name,
            'link' => route('admin.transaction.show', $transaction),
        ]);


    });

    return back()->with('success', 'Transaction refunded successfully. User wallet has been credited.');
}
    public function services()
    {
        return view('admin.service');
    }

    public function wallet()
    {
        return view('admin.wallet');
    }

    // public function deposit()
    // {
    //     return view('admin.deposit');
    // }

    public function withdrawal()
    {
        return view('admin.withdrawal');
    }

    public function kyc()
    {
        return view('admin.kyc');
    }

    public function referrals()
    {
        return view('admin.referral');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function reports()
    {
        return view('admin.report');
    }

    public function notifications()
    {
        return view('admin.notification');
    }

    public function profile()
    {
        $admin = auth()->guard('admin')->user();

        return view('admin.profile', compact('admin'));
    }

    public function security()
    {
        return view('admin.security');
    }

    public function search(Request $request)
    {
        $search = trim($request->search);

        $users = User::where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->get();

        $transactions = Transaction::where('reference', 'like', "%{$search}%")
            ->orWhere('service', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%")
            ->get();

        return view('admin.search', compact(
            'search',
            'users',
            'transactions'
        ));
    }


    public function creditWallet(Request $request, User $user)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $user->increment('wallet_balance', $request->amount);

    Transaction::create([
        'user_id'   => $user->id,
        'service'   => 'Admin Wallet Credit',
        'network'   => 'N/A',
        'phone'     => $user->phone,
        'amount'    => $request->amount,
        'type'      => 'credit',
        'status'    => 'Successful',
        'reference' => 'CR-' . strtoupper(Str::random(10)),
    ]);

    return back()->with('success', 'Wallet credited successfully.');
}

public function debitWallet(Request $request, User $user)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    if ($user->wallet_balance < $request->amount) {
        return back()->with('error', 'Insufficient wallet balance.');
    }

    $user->decrement('wallet_balance', $request->amount);

    Transaction::create([
        'user_id'   => $user->id,
        'service'   => 'Admin Wallet Debit',
        'network'   => 'N/A',
        'phone'     => $user->phone,
        'amount'    => $request->amount,
        'type'      => 'debit',
        'status'    => 'Successful',
        'reference' => 'DR-' . strtoupper(Str::random(10)),
    ]);

    return back()->with('success', 'Wallet debited successfully.');
}



public function deposit(Request $request)
{
    $query = Deposit::with('user');

    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('reference','like','%'.$request->search.'%')

            ->orWhereHas('user',function($user) use ($request){

                $user->where('name','like','%'.$request->search.'%')
                     ->orWhere('email','like','%'.$request->search.'%');

            });

        });

    }

    if ($request->filled('status')) {

        $query->where('status',$request->status);

    }

    $deposits = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.deposit',[
        'deposits'=>$deposits,

        'totalDeposits'=>Deposit::count(),

        'pendingDeposits'=>Deposit::where('status','pending')->count(),

        'approvedDeposits'=>Deposit::where('status','approved')->count(),

        'rejectedDeposits'=>Deposit::where('status','rejected')->count(),
    ]);
}

public function approveDeposit(Deposit $deposit)
{
    if($deposit->status != 'pending'){
        return back()->with('error','Deposit already processed.');
    }

    DB::transaction(function() use ($deposit){

        $deposit->user->increment(
            'wallet_balance',
            $deposit->amount
        );

        Transaction::create([

            'user_id'=>$deposit->user_id,

            'type'=>'Deposit',

            'amount'=>$deposit->amount,

            'status'=>'Successful',

            'reference'=>$deposit->reference,

            'description'=>'Wallet funding'

        ]);

        $deposit->update([

            'status'=>'approved',

            'approved_by'=>auth('admin')->id(),

            'approved_at'=>now()

        ]);

    });

    return back()->with('success','Deposit approved.');
}

public function rejectDeposit(Request $request, Deposit $deposit)
{
    if($deposit->status != 'pending'){
        return back()->with('error','Deposit already processed.');
    }

    $deposit->update([

        'status'=>'rejected',

        'remark'=>$request->remark,

        'approved_by'=>auth('admin')->id(),

        'approved_at'=>now()

    ]);

    return back()->with('success','Deposit rejected.');
}
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Deposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminNotification;
use App\Models\AuditLog;
use App\Http\Controllers\Admin\AuditLogController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    
        // Update basic information
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'] ?? null;
    
        // Handle profile photo
        if ($request->hasFile('profile_photo')) {
    
            // Delete old photo if it exists
            if ($admin->profile_photo && Storage::disk('public')->exists($admin->profile_photo)) {
                Storage::disk('public')->delete($admin->profile_photo);
            }
    
            // Store new photo
            $admin->profile_photo = $request->file('profile_photo')
                ->store('admin/profile_photos', 'public');
        }
    
        $admin->save();
    
        return redirect()
            ->route('admin.profile')
            ->with('success', 'Profile updated successfully.');
    }public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $admin = Auth::guard('admin')->user();

    // Check current password
    if (!Hash::check($request->current_password, $admin->password)) {
        return back()
            ->withErrors(['current_password' => 'Your current password is incorrect.'])
            ->withInput();
    }

    // Update password
    $admin->password = Hash::make($request->password);
    $admin->save();

    return back()->with('success', 'Password changed successfully.');
}
        public function readAll()
    {
        return view('admin.notification.read-all');
    }

    public function storeUser(Request $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'wallet_balance' => 0,
    ]);
    
    AuditLogController::record(
        'User Created',
        "Created user {$user->name} ({$user->email})"
    );
    
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

    AuditLogController::record(
        'User Updated',
        "Updated {$user->name}'s profile"
    );

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
    $name = $user->name;
    $email = $user->email;

    $user->delete();

    AuditLogController::record(
        'User Deleted',
        "Deleted user {$name} ({$email})"
    );

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
    $admin = auth('admin')->user();

    AdminNotification::create([
        'admin_id' => $admin->id,
        'created_by' => $admin->id,
        'title' => 'Transaction Approved',
        'message' => $admin->name .
                    ' approved transaction ' .
                    $transaction->reference,
        'link' => route('admin.transaction.show', $transaction),
        'recipient_type' => 'admin',
        'recipient' => (string) $admin->id,
        'push' => true,
        'email' => false,
        'sms' => false,
        'status' => 'Sent',
        'is_read' => false,
    ]);

    AuditLogController::record(
        'Transaction Approved',
        "Approved transaction {$transaction->reference}"
    );

    return back()->with(
        'success',
        'Transaction approved successfully.'
    );
}

public function reverseTransaction(Transaction $transaction)
{
    if ($transaction->status !== 'successful') {
        return back()->with(
            'error',
            'Only successful transactions can be reversed.'
        );
    }

    DB::transaction(function () use ($transaction) {

        $user = $transaction->user;
        $admin = auth('admin')->user();

        /*
        |--------------------------------------------------------------------------
        | Calculate actual refundable amount
        |--------------------------------------------------------------------------
        */

        $originalAmount = (float) $transaction->amount;

        $discount = $originalAmount * 0.02;

        $reverseAmount = $originalAmount - $discount;

        /*
        |--------------------------------------------------------------------------
        | 1. Credit actual amount back to user's wallet
        |--------------------------------------------------------------------------
        */

        $user->increment(
            'wallet_balance',
            $reverseAmount
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Mark transaction as reversed
        |--------------------------------------------------------------------------
        */

        $transaction->update([
            'status' => 'reversed',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Notify admin
        |--------------------------------------------------------------------------
        */

        AdminNotification::create([
            'admin_id' => $admin->id,
            'created_by' => $admin->id,
            'title' => 'Transaction Reversed',
            'message' => $admin->name .
                         ' reversed ₦' .
                         number_format($reverseAmount, 2) .
                         ' for ' .
                         $user->name,
            'link' => route(
                'admin.transaction.show',
                $transaction
            ),
            'recipient_type' => 'admin',
            'recipient' => (string) $admin->id,
            'push' => true,
            'email' => false,
            'sms' => false,
            'status' => 'Sent',
            'is_read' => false,
        ]);

    });

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    */

    $user = $transaction->user;

    $originalAmount = (float) $transaction->amount;
    $discount = $originalAmount * 0.02;
    $reverseAmount = $originalAmount - $discount;

    AuditLogController::record(
        'Transaction Reversed',
        "Reversed ₦" .
        number_format($reverseAmount, 2) .
        " for {$user->name}"
    );

    return back()->with(
        'success',
        'Transaction reversed successfully. The actual deducted amount has been credited back to the user.'
    );
}

public function refundTransaction(Transaction $transaction)
{
    if ($transaction->status !== 'successful') {
        return back()->with(
            'error',
            'Only successful transactions can be refunded.'
        );
    }

    DB::transaction(function () use ($transaction) {

        $user = $transaction->user;
        $admin = auth('admin')->user();



        
        /*
        |--------------------------------------------------------------------------
        | Calculate actual refundable amount
        |--------------------------------------------------------------------------
        | Original transaction: ₦100
        | 2% deduction:        ₦2
        | Actual refund:       ₦98
        |--------------------------------------------------------------------------
        */

        $originalAmount = (float) $transaction->amount;

        $discount = $originalAmount * 0.02;

        $refundAmount = $originalAmount - $discount;


        /*
        |--------------------------------------------------------------------------
        | 1. Credit the user's wallet
        |--------------------------------------------------------------------------
        */
        $user->increment(
            'wallet_balance',
            $refundAmount
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Mark the transaction as refunded
        |--------------------------------------------------------------------------
        */
        $transaction->update([
            'status' => 'refunded',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Notify the USER
        |--------------------------------------------------------------------------
        */
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Refund Successful',
            'message' => 'Your refund of ₦' .
                number_format($transaction->amount, 2) .
                ' has been processed successfully.',
            'link' => url('/dashboard/history'),
            'is_read' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4. Notify the ADMIN
        |--------------------------------------------------------------------------
        */
        AdminNotification::create([
            'admin_id' => $admin->id,
            'created_by' => $admin->id,
            'title' => 'Refund Processed',
            'message' => $admin->name .
                ' refunded ₦' .
                number_format($transaction->amount, 2) .
                ' to ' .
                $user->name,
            'link' => route(
                'admin.transaction.show',
                $transaction
            ),
            'recipient_type' => 'admin',
            'recipient' => (string) $admin->id,
            'push' => true,
            'email' => false,
            'sms' => false,
            'status' => 'Sent',
            'is_read' => false,
        ]);
    });

    
    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    */

    $user = $transaction->user;

    $originalAmount = (float) $transaction->amount;
    $discount = $originalAmount * 0.02;
    $refundAmount = $originalAmount - $discount;


    $user = $transaction->user;

    AuditLogController::record(
        'Transaction Refunded',
        "Refunded ₦" .
        number_format($transaction->amount, 2) .
        " to {$user->name}"
    );

    return back()->with(
        'success',
        'Transaction refunded successfully. User wallet has been credited with the actual refundable amount.'
    );
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
    $user->increment(
        'wallet_balance',
        $request->amount
    );
    
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
    
    AuditLogController::record(
        'Wallet Credited',
        "Credited ₦" . number_format($request->amount, 2) .
        " to {$user->name}"
    );

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

    AuditLogController::record(
        'Wallet Debited',
        "Debited ₦" . number_format($request->amount, 2) .
        " from {$user->name}"
    );

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

    AuditLogController::record(
        'Deposit Approved',
        "Approved ₦" .
        number_format($deposit->amount, 2) .
        " deposit for {$deposit->user->name}"
    );

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

    AuditLogController::record(
        'Deposit Rejected',
        "Rejected ₦" .
        number_format($deposit->amount, 2) .
        " deposit for {$deposit->user->name}"
    );

    return back()->with('success','Deposit rejected.');
}
}
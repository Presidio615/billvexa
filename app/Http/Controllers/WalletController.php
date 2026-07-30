<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\BankAccount;
use App\Models\Notification;

class WalletController extends Controller
{
    // Show Add Money page
    public function addMoney()
    {
        $accounts = BankAccount::where('status', true)->get();

        return view('wallet.add-money', compact('accounts'));
    }

    // Fund Wallet
    public function fund(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();

        // Update wallet balance
        $user->wallet_balance += $request->amount;
        $user->save();

        // Save transaction
        Transaction::create([
            'user_id'   => $user->id,
            'type'      => 'Credit',
            'service'   => 'Wallet Funding',
            'amount'    => $request->amount,
            'status'    => 'Successful',
            'reference' => 'BH' . strtoupper(uniqid()),
        ]);

        // Create notification
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Wallet Credited',
            'message' => '₦' . number_format($request->amount, 2) . ' has been added to your wallet.',
        ]);

        return back()->with(
            'success',
            '₦' . number_format($request->amount, 2) . ' added successfully.'
        );

    }
}
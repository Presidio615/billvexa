<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Notification;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->take(3)
            ->get();

        $accounts = BankAccount::where('status', true)->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('BillVexa.Dashboard.index', compact(
            'transactions',
            'accounts',
            'notifications',
            'unreadNotifications'
        ));
    }
}
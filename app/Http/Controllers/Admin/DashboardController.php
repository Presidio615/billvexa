<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
    
        $activeUsers = User::count();
    
        $todayUsers = User::whereDate('created_at', today())->count();
    
        $walletBalance = User::sum('wallet_balance');
    
        $todayRevenue = Transaction::whereDate('created_at', today())
            ->sum('amount');
    
        $transactions = Transaction::count();
    
        // Pending Withdrawals
        // Change this if you have a separate Withdrawal model
        $pendingWithdrawals = Transaction::where('type', 'withdrawal')
            ->where('status', 'pending')
            ->count();
    
        // Pending KYC
        $pendingKyc = User::where('nin_status', 'pending')->count();
    
        // Recent Transactions
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(10)
            ->get();
    
        // Recent Activities
        $recentActivities = Transaction::with('user')
            ->latest()
            ->take(8)
            ->get();
    
        // Revenue (Last 7 Days)
        $revenue = [];
    
        for ($i = 6; $i >= 0; $i--) {
    
            $date = Carbon::now()->subDays($i);
    
            $revenue[] = Transaction::whereDate('created_at', $date)
                ->sum('amount');
        }
    
        // Service Usage
        $serviceUsage = Transaction::select(
                'service',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('service')
            ->pluck('total', 'service');
    
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'todayUsers',
            'walletBalance',
            'todayRevenue',
            'transactions',
            'pendingWithdrawals',
            'pendingKyc',
            'recentTransactions',
            'recentActivities',
            'revenue',
            'serviceUsage'
        ));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
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

        // Status Filter

        if ($request->status != '') {

            switch ($request->status) {

                case 'verified':
                    $query->where('kyc_status', 'verified');
                    break;

                case 'pending':
                    $query->where('kyc_status', 'pending');
                    break;

                case 'suspended':
                    $query->where('status', 'suspended');
                    break;
            }
        }

        // Wallet Filter

        if ($request->wallet != '') {

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

            'total' => User::count(),

            'verified' => User::where('kyc_status', 'verified')->count(),

            'suspended' => User::where('status', 'suspended')->count(),

            'pending' => User::where('kyc_status', 'pending')->count(),

        ];

        return view('admin.users.index', compact(
            'users',
            'stats'
        ));
    }
}
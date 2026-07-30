<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Transaction;

use Illuminate\Http\Request;


class ReferralController extends Controller
{
    public function index(Request $request)
{
    $request->validate([
        'search' => 'nullable|string|max:100',
    ]);

    $query = User::with(['referrer'])
        ->whereNotNull('referred_by');

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhereHas('referrer', function ($user) use ($search) {

                  $user->where('name', 'LIKE', "%{$search}%")
                       ->orWhere('email', 'LIKE', "%{$search}%");

              });

        });
    }

    // Referral records for table
    $referrals = $query->latest()->paginate(10);

    // Top referrer
    $topReferrer = User::withCount('referrals')
        ->orderByDesc('referrals_count')
        ->first();

        

    return view('admin.referral', [

        'referrals' => $referrals,

        'totalReferrals' => User::whereNotNull('referred_by')->count(),

        'successfulReferrals' => User::whereNotNull('referred_by')->count(),

        'totalBonus' => Transaction::where('service', 'Referral Bonus')->sum('amount'),

        // 'topReferrer' => $topReferrer,

        'topReferrals' => $topReferrer?->referrals_count ?? 0,

    ]);
}

   
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KycController extends Controller
{
    /**
     * Display KYC requests
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->whereNotNull('nin')
            ->whereNotNull('nin_status');

        // Search
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('nin', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter

        if ($request->filled('status')) {
            $query->where('nin_status', $request->status);
        }

        $users = $query->latest()->paginate(15);

        return view('admin.kyc', [

            'users' => $users,

            'pending' => User::where('nin_status', 'pending')->count(),

            'approved' => User::where('nin_status', 'approved')->count(),

            'rejected' => User::where('nin_status', 'rejected')->count(),

        ]);
    }

    /**
     * View user KYC
     */

    public function show(User $user)
    {
        return view('admin.kyc.show', compact('user'));
    }

    /**
     * Approve KYC
     */

    public function approve(Request $request, User $user)
    {
        if ($user->nin_status == 'approved') {

            return back()->with('error', 'User already approved.');
        }

        DB::transaction(function () use ($user) {

            $user->update([

                'nin_status' => 'approved',

                'kyc_verified_at' => now(),

                'kyc_verified_by' => auth('admin')->id(),

                'kyc_rejection_reason' => null,

            ]);

            AdminNotification::create([

                'title' => 'KYC Approved',

                'message' => "{$user->name}'s KYC has been approved.",

                'link' => route('admin.kyc.show', $user),

                'is_read' => false,

            ]);
        });

        return back()->with('success', 'KYC approved successfully.');
    }

    /**
     * Reject KYC
     */

    public function reject(Request $request, User $user)
    {
        $request->validate([

            'reason' => 'required|string|max:255'

        ]);

        DB::transaction(function () use ($user, $request) {

            $user->update([

                'nin_status' => 'rejected',

                'kyc_verified_at' => null,

                'kyc_verified_by' => auth('admin')->id(),

                'kyc_rejection_reason' => $request->reason,

            ]);

            AdminNotification::create([

                'title' => 'KYC Rejected',

                'message' => "{$user->name}'s KYC was rejected.",

                'link' => route('admin.kyc.show', $user),

                'is_read' => false,

            ]);
        });

        return back()->with('success', 'KYC rejected.');
    }

    /**
     * Download KYC
     */

    public function download(User $user)
    {
        return response()->json($user);
    }
}
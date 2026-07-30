<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display the authenticated user's transaction history.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where('user_id', Auth::id())

            // Search
            ->when($request->filled('search'), function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where('reference', 'like', "%{$search}%")
                      ->orWhere('service', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");

                });

            })

            // Status Filter
            ->when($request->filled('status'), function ($query) use ($request) {

                $query->where('status', $request->status);

            })

            // From Date
            ->when($request->filled('from_date'), function ($query) use ($request) {

                $query->whereDate('created_at', '>=', $request->from_date);

            })

            // To Date
            ->when($request->filled('to_date'), function ($query) use ($request) {

                $query->whereDate('created_at', '<=', $request->to_date);

            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'BillVexa.Dashboard.transactions',
            compact('transactions')
        );
    }
}
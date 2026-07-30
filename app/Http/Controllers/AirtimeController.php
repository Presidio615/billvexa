<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AirtimeController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('service', 'Airtime')
            ->latest()
            ->take(3)
            ->get();

        return view('BillVexa.Dashboard.Quick.airtime', compact('transactions'));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'network' => 'required',
            'phone'   => 'required|digits:11',
            'amount'  => 'required|numeric|min:50',
        ]);

        $user = Auth::user();

        if ($user->wallet_balance < $request->amount) {

            return back()->with(
                'error',
                'Insufficient wallet balance.'
            )->withInput();
        }

        DB::beginTransaction();

        try {

            // Deduct wallet
            $user->wallet_balance -= $request->amount;
            $user->save();

            // Save transaction
            Transaction::create([

                'user_id'   => $user->id,

                'reference' => 'AIR-' . strtoupper(Str::random(10)),

                'service'   => 'Airtime',

                'type'      => $request->network,

                'network'   => $request->network,

                'phone'     => $request->phone,

                'amount'    => $request->amount,

                'status'    => 'Successful',

            ]);

            // Create notification
            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Airtime Purchase',
                'message' => 'Your airtime purchase of ₦' .
                            number_format($request->amount, 2) .
                            ' was successful.',
                'link' => route('history'),            
            ]);

            DB::commit();

            return redirect()
                ->route('airtime')
                ->with('success', 'Airtime purchase successful.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Transaction failed.'
            );
        }
    }
}
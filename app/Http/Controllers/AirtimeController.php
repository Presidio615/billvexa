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
            'phone' => 'required|digits:11',
            'amount' => 'required|numeric|min:50',
        ]);

        $user = Auth::user();

        // Get system settings
        $setting = \App\Models\Setting::first();

        // Airtime discount percentage
        $discountPercent = $setting->airtime_discount ?? 0;

        // Calculate discount
        $discount = ($request->amount * $discountPercent) / 100;

        // Amount user will actually pay
        $amountToPay = $request->amount - $discount;

        if ($user->wallet_balance < $amountToPay) {
            return back()
                ->with('error', 'Insufficient wallet balance.')
                ->withInput();
        }

        DB::beginTransaction();

        try {

            // Deduct wallet
            $user->wallet_balance -= $amountToPay;
            $user->save();

            // Save transaction
            Transaction::create([
                'user_id' => $user->id,
                'reference' => 'AIR-' . strtoupper(Str::random(10)),
                'service' => 'Airtime',
                'type' => $request->network,
                'network' => $request->network,
                'phone' => $request->phone,

                // Original airtime value
                'amount' => $request->amount,

                // Discount received
                'discount' => $discount,

                // Amount deducted from wallet
                'total' => $amountToPay,

                'status' => 'Successful',
            ]);

            // Notification
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Airtime Purchase',
                'message' => 'You purchased ₦' .
                    number_format($request->amount, 2) .
                    ' airtime and received ₦' .
                    number_format($discount, 2) .
                    ' discount. Amount deducted: ₦' .
                    number_format($amountToPay, 2),

                'link' => route('history'),
            ]);

            DB::commit();

            return redirect()
                ->route('airtime')
                ->with('success', 'Airtime purchase successful.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }
}    
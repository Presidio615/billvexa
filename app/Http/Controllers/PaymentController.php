<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
    public function webhook(Request $request)
    {
        // Verify the payment with Monnify/Paystack/Flutterwave

        $user = User::where(
            'account_reference',
            $request->paymentReference
        )->first();

        if ($user) {

            $amount = $request->amountPaid;

            $user->wallet_balance += $amount;
            $user->save();
        }

        return response()->json([
            'message' => 'Success'
        ]);
    }
}
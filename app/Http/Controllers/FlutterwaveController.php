<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FlutterwaveController extends Controller
{
    /**
     * Start Flutterwave wallet funding.
     */
    public function initialize(Request $request)
    {
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:100',
                'max:1000000',
            ],
        ]);

        $user = auth()->user();

        $amount = (float) $request->amount;

        /*
        |--------------------------------------------------------------------------
        | Generate unique transaction reference
        |--------------------------------------------------------------------------
        */

        $txRef = 'WALLET-' . strtoupper(Str::random(20));

        /*
        |--------------------------------------------------------------------------
        | Create pending transaction
        |--------------------------------------------------------------------------
        */

        Transaction::create([
            'user_id'   => $user->id,
            'type'      => 'deposit',
            'service'   => 'Wallet Funding',
            'network'   => null,
            'phone'     => null,
            'amount'    => $amount,
            'discount'  => 0,
            'profit'    => 0,
            'total'     => $amount,
            'reference' => $txRef,
            'status'    => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Send payment request to Flutterwave
        |--------------------------------------------------------------------------
        */

        $response = Http::withToken(config('services.flutterwave.secret'))
            ->acceptJson()
            ->post('https://api.flutterwave.com/v3/payments', [

                'tx_ref' => $txRef,

                'amount' => $amount,

                'currency' => 'NGN',

                'redirect_url' => route('flutterwave.callback'),

                'customer' => [
                    'email' => $user->email,
                    'name' => $user->name,
                    'phonenumber' => $user->phone ?? null,
                ],

                'customizations' => [
                    'title' => config('app.name', 'BillVexa'),
                    'description' => 'Wallet Funding',
                ],

                'meta' => [
                    'user_id' => $user->id,
                    'type' => 'wallet_funding',
                ],
            ]);

        /*
        |--------------------------------------------------------------------------
        | Flutterwave request failed
        |--------------------------------------------------------------------------
        */

        if (!$response->successful()) {

            Transaction::where('reference', $txRef)
                ->update([
                    'status' => 'failed',
                ]);

            return back()->with(
                'error',
                'Unable to initialize Flutterwave payment.'
            );
        }

        $data = $response->json();

        /*
        |--------------------------------------------------------------------------
        | Make sure Flutterwave returned a payment link
        |--------------------------------------------------------------------------
        */

        if (
            ($data['status'] ?? null) !== 'success' ||
            empty($data['data']['link'])
        ) {

            Transaction::where('reference', $txRef)
                ->update([
                    'status' => 'failed',
                ]);

            return back()->with(
                'error',
                'Flutterwave did not return a payment link.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect user to Flutterwave checkout
        |--------------------------------------------------------------------------
        */

        return redirect()->away($data['data']['link']);
    }


    /**
     * Flutterwave redirects the user here after payment.
     */
    public function callback(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $txRef = $request->query('tx_ref');

        if (!$transactionId || !$txRef) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Invalid Flutterwave payment response.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Find our transaction
        |--------------------------------------------------------------------------
        */

        $transaction = Transaction::where(
            'reference',
            $txRef
        )->first();

        if (!$transaction) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Transaction not found.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate wallet credit
        |--------------------------------------------------------------------------
        */

        if ($transaction->status === 'successful') {

            return redirect()
                ->route('dashboard')
                ->with(
                    'success',
                    'This payment has already been processed.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Verify transaction directly with Flutterwave
        |--------------------------------------------------------------------------
        */

        $response = Http::withToken(config('services.flutterwave.secret'))
            ->acceptJson()
            ->get(
                "https://api.flutterwave.com/v3/transactions/{$transactionId}/verify"
            );

        if (!$response->successful()) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Unable to verify Flutterwave payment.'
                );
        }

        $data = $response->json();

        if (($data['status'] ?? null) !== 'success') {

            $transaction->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Payment verification failed.'
                );
        }

        $flutterwaveTransaction = $data['data'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Verify payment status
        |--------------------------------------------------------------------------
        */

        if (
            ($flutterwaveTransaction['status'] ?? null)
            !== 'successful'
        ) {

            $transaction->update([
                'status' => 'failed',
            ]);

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Flutterwave payment was not successful.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Verify transaction reference
        |--------------------------------------------------------------------------
        */

        $flutterwaveReference =
            $flutterwaveTransaction['tx_ref']
            ?? null;

        if ($flutterwaveReference !== $transaction->reference) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Transaction reference mismatch.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Verify currency
        |--------------------------------------------------------------------------
        */

        if (
            ($flutterwaveTransaction['currency'] ?? null)
            !== 'NGN'
        ) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Transaction currency mismatch.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Verify amount
        |--------------------------------------------------------------------------
        */

        $paidAmount = (float) (
            $flutterwaveTransaction['amount'] ?? 0
        );

        if ($paidAmount < (float) $transaction->amount) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'The amount paid is less than the required amount.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Credit wallet
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $transaction,
            $transactionId
        ) {

            /*
            |--------------------------------------------------------------------------
            | Lock transaction row
            |--------------------------------------------------------------------------
            */

            $transaction = Transaction::where(
                'id',
                $transaction->id
            )
                ->lockForUpdate()
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Check again to prevent duplicate credit
            |--------------------------------------------------------------------------
            */

            if ($transaction->status === 'successful') {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Lock user
            |--------------------------------------------------------------------------
            */

            $user = $transaction->user()
                ->lockForUpdate()
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Credit wallet
            |--------------------------------------------------------------------------
            */

            $user->increment(
                'wallet_balance',
                $transaction->amount
            );

            /*
            |--------------------------------------------------------------------------
            | Mark transaction successful
            |--------------------------------------------------------------------------
            */

            $transaction->update([
                'status' => 'successful',
            ]);
        });

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                '₦' .
                number_format($transaction->amount, 2) .
                ' has been added to your wallet.'
            );
    }
}
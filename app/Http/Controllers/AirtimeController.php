<?php

namespace App\Http\Controllers;

use App\Models\AirtimeTransaction;
use App\Services\VtpassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class AirtimeController extends Controller
{
    protected VtpassService $vtpass;

    public function __construct(VtpassService $vtpass)
    {
        $this->vtpass = $vtpass;
    }

    /**
     * Airtime page
     */
    public function index()
    {
        $transactions = AirtimeTransaction::where(
            'user_id',
            auth()->id()
        )
            ->latest()
            ->take(5)
            ->get();

        return view('Billvexa.Dashboard.Quick.airtime', compact('transactions'));
    }

    /**
     * Purchase Airtime
     */
    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'network' => [
                'required',
                'in:MTN,Glo,Airtel,9mobile',
            ],

            'phone' => [
                'required',
                'regex:/^[0-9]{10,15}$/',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:50',
                'max:100000',
            ],
        ]);

        $serviceIds = [
            'MTN' => 'mtn',
            'Glo' => 'glo',
            'Airtel' => 'airtel',
            '9mobile' => 'etisalat',
        ];

        $network = $validated['network'];

        $serviceId = $serviceIds[$network];

        $amount = (float) $validated['amount'];

        $discountRate = (float) (
            auth()->user()->airtime_discount
            ?? config('services.airtime.discount', 0)
        );

        $discount = round(
            $amount * ($discountRate / 100),
            2
        );

        $total = round(
            $amount - $discount,
            2
        );

        $requestId = now()->format('YmdHis')
            . Str::upper(Str::random(8));

        try {

            $transaction = DB::transaction(function () use (
                $request,
                $amount,
                $discount,
                $total,
                $network,
                $serviceId,
                $requestId
            ) {

                $user = auth()->user()->lockForUpdate()->first();

                if ($user->wallet_balance < $total) {
                    throw new \RuntimeException(
                        'Insufficient wallet balance.'
                    );
                }

                $user->wallet_balance -= $total;
                $user->save();

                return AirtimeTransaction::create([
                    'user_id' => $user->id,

                    'request_id' => $requestId,

                    'network' => $network,

                    'service_id' => $serviceId,

                    'phone' => $request->phone,

                    'amount' => $amount,

                    'discount' => $discount,

                    'total' => $total,

                    'status' => 'pending',
                ]);
            });

            $response = $this->vtpass->airtimePurchase(
                $serviceId,
                $validated['phone'],
                $amount,
                $requestId
            );

            $transactionId =
                $response['transaction']['transactionId']
                ?? null;

            $status =
                $response['content']['transactions']['status']
                ?? $response['transaction']['status']
                ?? null;

            $message =
                $response['response_description']
                ?? $response['content']['transactions']['status']
                ?? 'Airtime purchase processed.';

            /*
             * SUCCESS
             */
            if (
                ($response['code'] ?? null) === '000'
                && $status === 'delivered'
            ) {

                $transaction->update([
                    'status' => 'delivered',

                    'vtpass_transaction_id' =>
                        $transactionId,

                    'response_message' =>
                        $message,

                    'api_response' =>
                        $response,

                    'purchased_at' =>
                        now(),
                ]);

                return back()->with(
                    'success',
                    'Airtime purchased successfully.'
                );
            }

            /*
             * PENDING
             */
            if (
                in_array(
                    strtolower((string) $status),
                    ['pending', 'initiated', 'processing']
                )
            ) {

                $transaction->update([
                    'status' => 'pending',

                    'vtpass_transaction_id' =>
                        $transactionId,

                    'response_message' =>
                        $message,

                    'api_response' =>
                        $response,
                ]);

                return back()->with(
                    'success',
                    'Airtime purchase is processing. Please check your transaction history.'
                );
            }

            /*
             * FAILED
             */
            $transaction->update([
                'status' => 'failed',

                'vtpass_transaction_id' =>
                    $transactionId,

                'response_message' =>
                    $message,

                'api_response' =>
                    $response,
            ]);

            $this->refund(
                $transaction->user_id,
                $transaction->total
            );

            return back()->with(
                'error',
                'Airtime purchase failed. Your wallet has been refunded.'
            );

        } catch (Throwable $e) {

            /*
             * Do not automatically refund when the
             * VTpass result is unknown.
             */

            if (isset($transaction)) {

                $transaction->update([
                    'status' => 'pending',

                    'response_message' =>
                        $e->getMessage(),
                ]);
            }

            return back()->with(
                'error',
                'Airtime purchase could not be confirmed. Please check your transaction history before trying again.'
            );
        }
    }

    /**
     * Refund wallet
     */
    private function refund(
        int $userId,
        float|string $amount
    ): void {

        DB::transaction(function () use (
            $userId,
            $amount
        ) {

            $user = \App\Models\User::lockForUpdate()
                ->findOrFail($userId);

            $user->wallet_balance += $amount;

            $user->save();
        });
    }
}
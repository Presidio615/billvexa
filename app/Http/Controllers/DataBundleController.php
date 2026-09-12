<?php

namespace App\Http\Controllers;

use App\Models\DataBundleTransaction;
use App\Models\Transaction;
use App\Services\VtpassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use RuntimeException;

class DataBundleController extends Controller
{
    protected VtpassService $vtpass;

    public function __construct(VtpassService $vtpass)
    {
        $this->vtpass = $vtpass;
    }

    /**
     * Show Data Bundle page.
     */
    public function index()
    {
        $user = auth()->user();

        $transactions = DataBundleTransaction::where(
            'user_id',
            $user->id
        )
            ->latest()
            ->take(5)
            ->get();

        return view(
            'BillVexa.Dashboard.Quick.data',
            compact('transactions')
        );
    }

    /**
     * Get available data plans.
     */
    public function plans(Request $request)
    {
        $request->validate([
            'network' => [
                'required',
                Rule::in([
                    'mtn',
                    'glo',
                    'airtel',
                    '9mobile',
                ]),
            ],
        ]);

        $serviceIds = [
            'mtn' => 'mtn-data',
            'glo' => 'glo-data',
            'airtel' => 'airtel-data',
            '9mobile' => 'etisalat-data',
        ];

        $network = $request->network;

        $serviceId = $serviceIds[$network];

        try {

            $response = $this->vtpass->variations($serviceId);

            if (($response['code'] ?? '000') !== '000') {
                return response()->json([
                    'success' => false,
                    'message' => $response['response_description']
                        ?? 'Unable to load data plans.',
                ], 422);
            }

            $content = $response['content'] ?? [];

            $variations = $content['variations']
                ?? $content['varations']
                ?? [];

            return response()->json([
                'success' => true,
                'network' => $network,
                'service_id' => $serviceId,
                'plans' => $variations,
            ]);

        } catch (\Throwable $e) {

            Log::error('VTpass Data Plans Error', [
                'network' => $network,
                'service_id' => $serviceId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to VTpass right now.',
            ], 500);
        }
    }

    /**
     * Purchase Data Bundle.
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'network' => [
                'required',
                Rule::in([
                    'mtn',
                    'glo',
                    'airtel',
                    '9mobile',
                ]),
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]{10,15}$/',
            ],

            'variation_code' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $user = auth()->user();

        $serviceIds = [
            'mtn' => 'mtn-data',
            'glo' => 'glo-data',
            'airtel' => 'airtel-data',
            '9mobile' => 'etisalat-data',
        ];

        $network = $request->network;

        $serviceId = $serviceIds[$network];

        /*
         * Do not trust the amount sent by JavaScript.
         * Get the current variation directly from VTpass.
         */
        try {

            $variationResponse = $this->vtpass->variations(
                $serviceId
            );

            if (($variationResponse['code'] ?? '000') !== '000') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to verify selected data plan.',
                ], 422);
            }

            $content = $variationResponse['content'] ?? [];

            $variations = $content['variations']
                ?? $content['varations']
                ?? [];

            $selectedVariation = collect($variations)
                ->first(function ($variation) use ($request) {
                    return ($variation['variation_code'] ?? null)
                        === $request->variation_code;
                });

            if (!$selectedVariation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected data plan is no longer available.',
                ], 422);
            }

            $amount = (float) (
                $selectedVariation['variation_amount'] ?? 0
            );

            $variationName = $selectedVariation['name'] ?? null;

            if ($amount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data plan amount.',
                ], 422);
            }

        } catch (\Throwable $e) {

            Log::error('VTpass Data Variation Verification Error', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to verify the data plan.',
            ], 500);
        }

        /*
         * Generate unique VTpass request ID.
         */
        $requestId = $this->vtpass->generateRequestId();

        /*
         * Create BOTH:
         *
         * 1. DataBundleTransaction
         * 2. General Transaction
         *
         * and deduct wallet atomically.
         */
        try {

            $transaction = DB::transaction(function () use (
                $user,
                $request,
                $network,
                $serviceId,
                $requestId,
                $amount,
                $variationName
            ) {

                $lockedUser = $user->newQuery()
                    ->where('id', $user->id)
                    ->lockForUpdate()
                    ->first();

                if (!$lockedUser) {
                    throw new RuntimeException(
                        'User account could not be found.'
                    );
                }

                $walletBalance = (float) $lockedUser->wallet_balance;

                if ($walletBalance < $amount) {
                    throw new RuntimeException(
                        'Insufficient wallet balance.'
                    );
                }

                /*
                 * Deduct wallet.
                 */
                $lockedUser->wallet_balance =
                    $walletBalance - $amount;

                $lockedUser->save();

                /*
                 * Create service-specific transaction.
                 */
                $dataTransaction = DataBundleTransaction::create([
                    'user_id' => $lockedUser->id,

                    'request_id' => $requestId,

                    'network' => strtoupper($network),

                    'service_id' => $serviceId,

                    'variation_code' =>
                        $request->variation_code,

                    'variation_name' =>
                        $variationName,

                    'phone' => $request->phone,

                    'amount' => $amount,

                    'status' => 'pending',
                ]);

                /*
                 * Create GENERAL transaction.
                 *
                 * This is what appears in:
                 *
                 * User Transaction History
                 * Admin Transaction Management
                 */
                Transaction::create([
                    'user_id' => $lockedUser->id,

                    'type' => 'debit',

                    'service' => 'Data',

                    'network' => strtoupper($network),

                    'phone' => $request->phone,

                    'amount' => $amount,

                    'status' => 'pending',

                    'reference' => $requestId,

                    'discount' => 0,

                    'profit' => 0,

                    'total' => $amount,
                ]);

                return $dataTransaction;
            });

        } catch (RuntimeException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        /*
         * Send purchase request to VTpass.
         */
        try {

            $response = $this->vtpass->purchase([
                'request_id' => $requestId,

                'serviceID' => $serviceId,

                'billersCode' => $request->phone,

                'variation_code' =>
                    $request->variation_code,

                'amount' => $amount,

                'phone' => $request->phone,
            ]);

            $vtpassTransaction =
                $response['content']['transactions'] ?? [];

            $status =
                strtolower(
                    $vtpassTransaction['status'] ?? ''
                );

            $transactionId =
                $vtpassTransaction['transactionId']
                ?? null;

            /*
             * Find the GENERAL transaction.
             */
            $generalTransaction = Transaction::where(
                'reference',
                $requestId
            )->first();

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
                        $response['response_description']
                        ?? 'Data bundle delivered successfully.',

                    'api_response' => $response,

                    'purchased_at' => now(),
                ]);

                /*
                 * Update GENERAL transaction.
                 */
                if ($generalTransaction) {
                    $generalTransaction->update([
                        'status' => 'successful',
                    ]);
                }

                return response()->json([
                    'success' => true,

                    'status' => 'delivered',

                    'message' =>
                        'Data bundle purchased successfully.',

                    'transaction_id' =>
                        $transaction->id,

                    'amount' => $amount,

                    'phone' => $request->phone,

                    'receipt_url' => route(
                        'transaction.receipt',
                        $generalTransaction
                    ),
                ]);
            }

            /*
             * PENDING
             */
            if ($status === 'pending') {

                $transaction->update([
                    'status' => 'pending',

                    'vtpass_transaction_id' =>
                        $transactionId,

                    'response_message' =>
                        $response['response_description']
                        ?? 'Transaction is pending.',

                    'api_response' => $response,
                ]);

                /*
                 * General transaction remains pending.
                 */
                if ($generalTransaction) {
                    $generalTransaction->update([
                        'status' => 'pending',
                    ]);
                }

                return response()->json([
                    'success' => true,

                    'status' => 'pending',

                    'message' =>
                        'Your data purchase is being processed.',

                    'transaction_id' =>
                        $transaction->id,
                ]);
            }

            /*
             * FAILED
             *
             * Refund wallet.
             */
            $this->refundWallet(
                $user->id,
                $amount
            );

            $transaction->update([
                'status' => 'failed',

                'vtpass_transaction_id' =>
                    $transactionId,

                'response_message' =>
                    $response['response_description']
                    ?? 'Data purchase failed.',

                'api_response' => $response,
            ]);

            /*
             * Update GENERAL transaction.
             */
            if ($generalTransaction) {
                $generalTransaction->update([
                    'status' => 'refunded',
                ]);
            }

            return response()->json([
                'success' => false,

                'status' => 'failed',

                'message' =>
                    $response['response_description']
                    ?? 'Data purchase failed. Your wallet has been refunded.',
            ], 422);

        } catch (\Throwable $e) {

            Log::error('VTpass Data Purchase Error', [
                'request_id' => $requestId,

                'transaction_id' =>
                    $transaction->id,

                'error' => $e->getMessage(),
            ]);

            /*
             * Do NOT immediately refund on timeout/unknown
             * outcome. Requery VTpass first.
             */
            try {

                $requery =
                    $this->vtpass->requery($requestId);

                $requeryTransaction =
                    $requery['content']['transactions'] ?? [];

                $requeryStatus =
                    strtolower(
                        $requeryTransaction['status']
                        ?? ''
                    );

                /*
                 * Find general transaction.
                 */
                $generalTransaction = Transaction::where(
                    'reference',
                    $requestId
                )->first();

                /*
                 * DELIVERED
                 */
                if ($requeryStatus === 'delivered') {

                    $transaction->update([
                        'status' => 'delivered',

                        'vtpass_transaction_id' =>
                            $requeryTransaction['transactionId']
                            ?? null,

                        'response_message' =>
                            'Data bundle delivered successfully.',

                        'api_response' => $requery,

                        'purchased_at' => now(),
                    ]);

                    if ($generalTransaction) {
                        $generalTransaction->update([
                            'status' => 'successful',
                        ]);
                    }

                    return response()->json([
                        'success' => true,

                        'status' => 'delivered',

                        'message' =>
                            'Data bundle purchased successfully.',
                    ]);
                }

                /*
                 * PENDING
                 */
                if ($requeryStatus === 'pending') {

                    $transaction->update([
                        'status' => 'pending',

                        'api_response' => $requery,

                        'response_message' =>
                            'Transaction is still being processed.',
                    ]);

                    if ($generalTransaction) {
                        $generalTransaction->update([
                            'status' => 'pending',
                        ]);
                    }

                    return response()->json([
                        'success' => true,

                        'status' => 'pending',

                        'message' =>
                            'Your data purchase is still being processed.',
                    ]);
                }

                /*
                 * CONFIRMED FAILURE
                 */
                $this->refundWallet(
                    $user->id,
                    $amount
                );

                $transaction->update([
                    'status' => 'failed',

                    'api_response' => $requery,

                    'response_message' =>
                        'Transaction failed. Wallet refunded.',
                ]);

                if ($generalTransaction) {
                    $generalTransaction->update([
                        'status' => 'refunded',
                    ]);
                }

                return response()->json([
                    'success' => false,

                    'status' => 'failed',

                    'message' =>
                        'Data purchase failed. Your wallet has been refunded.',
                ], 422);

            } catch (\Throwable $requeryException) {

                /*
                 * Unknown transaction state.
                 *
                 * Keep both transactions pending.
                 */
                $transaction->update([
                    'status' => 'pending',

                    'response_message' =>
                        'Transaction status is being checked.',
                ]);

                $generalTransaction = Transaction::where(
                    'reference',
                    $requestId
                )->first();

                if ($generalTransaction) {
                    $generalTransaction->update([
                        'status' => 'pending',
                    ]);
                }

                return response()->json([
                    'success' => false,

                    'status' => 'pending',

                    'message' =>
                        'We could not confirm the transaction yet. Please check your transaction history.',
                ], 202);
            }
        }
    }

    /**
     * Requery a Data transaction.
     */
    public function requery(string $requestId)
    {
        $transaction = DataBundleTransaction::where(
            'request_id',
            $requestId
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->firstOrFail();

        /*
         * Find the GENERAL transaction using
         * the same VTpass request ID.
         */
        $generalTransaction = Transaction::where(
            'reference',
            $requestId
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->first();

        try {

            $response =
                $this->vtpass->requery($requestId);

            $vtpassTransaction =
                $response['content']['transactions'] ?? [];

            $status =
                strtolower(
                    $vtpassTransaction['status'] ?? ''
                );

            /*
             * DELIVERED
             */
            if ($status === 'delivered') {

                $transaction->update([
                    'status' => 'delivered',

                    'vtpass_transaction_id' =>
                        $vtpassTransaction['transactionId']
                        ?? $transaction->vtpass_transaction_id,

                    'response_message' =>
                        'Transaction delivered successfully.',

                    'api_response' => $response,

                    'purchased_at' =>
                        $transaction->purchased_at
                        ?? now(),
                ]);

                /*
                 * Update general history.
                 */
                if ($generalTransaction) {
                    $generalTransaction->update([
                        'status' => 'successful',
                    ]);
                }

                return response()->json([
                    'success' => true,

                    'status' => 'delivered',

                    'message' =>
                        'Data bundle delivered successfully.',
                ]);
            }

            /*
             * FAILED
             */
            if (
                in_array(
                    $status,
                    ['failed', 'reversed', 'cancelled']
                )
                && $transaction->status !== 'failed'
            ) {

                $this->refundWallet(
                    $transaction->user_id,
                    (float) $transaction->amount
                );

                $transaction->update([
                    'status' => 'failed',

                    'response_message' =>
                        'Transaction failed. Wallet refunded.',

                    'api_response' => $response,
                ]);

                /*
                 * Update general history.
                 */
                if ($generalTransaction) {
                    $generalTransaction->update([
                        'status' => 'refunded',
                    ]);
                }

                return response()->json([
                    'success' => false,

                    'status' => 'failed',

                    'message' =>
                        'Transaction failed. Your wallet has been refunded.',
                ]);
            }

            /*
             * STILL PENDING
             */
            $transaction->update([
                'status' => 'pending',

                'api_response' => $response,
            ]);

            if ($generalTransaction) {
                $generalTransaction->update([
                    'status' => 'pending',
                ]);
            }

            return response()->json([
                'success' => true,

                'status' => 'pending',

                'message' =>
                    'Transaction is still pending.',
            ]);

        } catch (\Throwable $e) {

            Log::error('Data Transaction Requery Error', [
                'request_id' => $requestId,

                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,

                'message' =>
                    'Unable to check transaction status.',
            ], 500);
        }
    }

    /**
     * Refund wallet.
     */
    protected function refundWallet(
        int $userId,
        float $amount
    ): void {

        DB::transaction(function () use (
            $userId,
            $amount
        ) {

            $user = \App\Models\User::where(
                'id',
                $userId
            )
                ->lockForUpdate()
                ->first();

            if (!$user) {
                return;
            }

            $user->wallet_balance =
                (float) $user->wallet_balance + $amount;

            $user->save();
        });
    }
}
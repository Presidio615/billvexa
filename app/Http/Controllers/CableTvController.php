<?php

namespace App\Http\Controllers;

use App\Models\CableTvTransaction;
use App\Services\VtpassService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class CableTvController extends Controller
{
    public function __construct(
        protected VtpassService $vtpass
    ) {
    }

    /**
     * Show cable TV page.
     */
    public function index()
    {
        $user = auth()->user();

        $transactions = CableTvTransaction::where(
            'user_id',
            $user->id
        )
            ->latest()
            ->take(5)
            ->get();

        return view('BillVexa.Dashboard.Quick.cable', compact(
            'transactions'
        ));
    }

    /**
     * Get plans for selected provider.
     */
    public function plans(
        Request $request
    ): JsonResponse {
        $request->validate([
            'provider' => [
                'required',
                'in:dstv,gotv,startimes',
            ],
        ]);

        try {
            $plans = $this->vtpass->variations(
                $request->provider
            );

            return response()->json([
                'success' => true,
                'plans' => $plans,
            ]);
        } catch (Throwable $e) {

            Log::error(
                'Cable TV plans error',
                [
                    'error' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Verify smart card/IUC.
     */
    public function verify(
        Request $request
    ): JsonResponse {
        $validated = $request->validate([
            'provider' => [
                'required',
                'in:dstv,gotv,startimes',
            ],

            'smart_card' => [
                'required',
                'string',
                'min:5',
                'max:30',
            ],
        ]);

        try {
            $customer = $this->vtpass->verify(
                $validated['provider'],
                $validated['smart_card']
            );

            return response()->json([
                'success' => true,

                'customer' => [
                    'name' =>
                        $customer['Customer_Name']
                        ?? $customer['customer_name']
                        ?? null,

                    'status' =>
                        $customer['Status']
                        ?? $customer['status']
                        ?? null,

                    'due_date' =>
                        $customer['Due_Date']
                        ?? $customer['due_date']
                        ?? null,

                    'renewal_amount' =>
                        $customer['Renewal_Amount']
                        ?? $customer['renewal_amount']
                        ?? null,

                    'current_bouquet' =>
                        $customer['Current_Bouquet']
                        ?? $customer['current_bouquet']
                        ?? null,
                ],

                'raw' => $customer,
            ]);
        } catch (Throwable $e) {

            Log::warning(
                'Cable TV verification failed',
                [
                    'provider' =>
                        $validated['provider'],

                    'smart_card' =>
                        $validated['smart_card'],

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Purchase cable TV subscription.
     */
    public function purchase(
        Request $request
    ): JsonResponse {
        $validated = $request->validate([
            'provider' => [
                'required',
                'in:dstv,gotv,startimes',
            ],

            'smart_card' => [
                'required',
                'string',
                'min:5',
                'max:30',
            ],

            'variation_code' => [
                'required',
                'string',
                'max:100',
            ],

            'variation_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],
        ]);

        $user = auth()->user();

        $amount = round(
            (float) $validated['amount'],
            2
        );

        /*
         * Generate a unique VTpass request ID.
         */
        $requestId = $this->vtpass->generateRequestId()
            .strtoupper(Str::random(8));

        try {

            /*
             * STEP 1
             *
             * Create local transaction as pending.
             */
            $transaction = CableTvTransaction::create([
                'user_id' => $user->id,

                'request_id' => $requestId,

                'provider' =>
                    $validated['provider'],

                'service_id' =>
                    $validated['provider'],

                'variation_code' =>
                    $validated['variation_code'],

                'variation_name' =>
                    $validated['variation_name']
                    ?? null,

                'smart_card' =>
                    $validated['smart_card'],

                'amount' => $amount,

                'status' => 'pending',
            ]);

            /*
             * STEP 2
             *
             * Deduct wallet atomically.
             */
            $debited = DB::transaction(
                function () use (
                    $user,
                    $amount
                ) {

                    $lockedUser = $user
                        ->newQuery()
                        ->where('id', $user->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$lockedUser) {
                        return false;
                    }

                    $balance = (float)
                        $lockedUser->wallet_balance;

                    if ($balance < $amount) {
                        return false;
                    }

                    $lockedUser->wallet_balance =
                        $balance - $amount;

                    $lockedUser->save();

                    return true;
                }
            );

            /*
             * Wallet has insufficient funds.
             */
            if (!$debited) {

                $transaction->update([
                    'status' => 'failed',

                    'response_message' =>
                        'Insufficient wallet balance.',
                ]);

                return response()->json([
                    'success' => false,

                    'message' =>
                        'Insufficient wallet balance.',
                ], 422);
            }

            /*
             * STEP 3
             *
             * Purchase from VTpass.
             */
            $payload = [
                'request_id' => $requestId,

                'serviceID' =>
                    $validated['provider'],

                'billersCode' =>
                    $validated['smart_card'],

                'variation_code' =>
                    $validated['variation_code'],

                'amount' => $amount,

                'phone' =>
                    $user->phone
                    ?? $user->phone_number
                    ?? '08000000000',

                'subscription_type' => 'change',
            ];

            $response = $this->vtpass->purchase(
                $payload
            );

            /*
             * Save complete API response.
             */
            $transaction->update([
                'api_response' => $response,

                'vtpass_transaction_id' =>
                    data_get(
                        $response,
                        'content.transactions.transactionId'
                    ),
            ]);

            /*
             * VTpass SUCCESS.
             */
            $code = $response['code']
                ?? null;

            $status = strtolower(
                data_get(
                    $response,
                    'content.transactions.status',
                    ''
                )
            );

            if (
                $code === '000'
                &&
                in_array(
                    $status,
                    [
                        'delivered',
                        'successful',
                    ],
                    true
                )
            ) {

                $customerName =
                    data_get(
                        $response,
                        'content.transactions.name'
                    );

                $transaction->update([
                    'status' => 'delivered',

                    'customer_name' =>
                        $customerName,

                    'response_message' =>
                        $response[
                            'response_description'
                        ]
                        ?? 'Cable TV subscription successful.',

                    'purchased_at' => now(),
                ]);

                return response()->json([
                    'success' => true,

                    'status' => 'delivered',

                    'message' =>
                        'Cable TV subscription successful.',

                    'transaction' => [
                        'id' =>
                            $transaction->id,

                        'amount' =>
                            number_format(
                                $amount,
                                2
                            ),

                        'smart_card' =>
                            $validated['smart_card'],

                        'provider' =>
                            strtoupper(
                                $validated['provider']
                            ),

                        'plan' =>
                            $validated['variation_name']
                            ?? $validated['variation_code'],

                        'reference' =>
                            $requestId,
                    ],
                ]);
            }

            /*
             * VTpass can return a pending state.
             */
            if (
                in_array(
                    $status,
                    [
                        'pending',
                        'processing',
                    ],
                    true
                )
            ) {

                $transaction->update([
                    'status' => 'pending',

                    'response_message' =>
                        $response[
                            'response_description'
                        ]
                        ?? 'Transaction is processing.',
                ]);

                return response()->json([
                    'success' => true,

                    'status' => 'pending',

                    'message' =>
                        'Your cable TV transaction is being processed.',

                    'reference' =>
                        $requestId,
                ]);
            }

            /*
             * VTpass failed.
             *
             * Refund wallet.
             */
            $this->refundWallet(
                $user->id,
                $amount
            );

            $transaction->update([
                'status' => 'refunded',

                'response_message' =>
                    $response[
                        'response_description'
                    ]
                    ?? 'Cable TV transaction failed.',
            ]);

            return response()->json([
                'success' => false,

                'status' => 'refunded',

                'message' =>
                    $response[
                        'response_description'
                    ]
                    ?? 'Cable TV transaction failed. Your wallet has been refunded.',
            ], 422);

        } catch (Throwable $e) {

            Log::error(
                'Cable TV purchase exception',
                [
                    'user_id' =>
                        $user->id,

                    'request_id' =>
                        $requestId,

                    'error' =>
                        $e->getMessage(),

                    'trace' =>
                        $e->getTraceAsString(),
                ]
            );

            /*
             * Refund if money was already deducted.
             */
            try {

                if (
                    isset($transaction)
                    &&
                    $transaction->status === 'pending'
                ) {

                    $this->refundWallet(
                        $user->id,
                        $amount
                    );

                    $transaction->update([
                        'status' => 'refunded',

                        'response_message' =>
                            'Transaction failed. Wallet refunded.',
                    ]);
                }

            } catch (Throwable $refundException) {

                Log::critical(
                    'Cable TV wallet refund failed',
                    [
                        'user_id' =>
                            $user->id,

                        'amount' =>
                            $amount,

                        'error' =>
                            $refundException->getMessage(),
                    ]
                );
            }

            return response()->json([
                'success' => false,

                'message' =>
                    'Unable to complete the cable TV transaction. Please try again.',
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

        DB::transaction(
            function () use (
                $userId,
                $amount
            ) {

                $user = \App\Models\User::query()
                    ->where('id', $userId)
                    ->lockForUpdate()
                    ->first();

                if (!$user) {
                    throw new \RuntimeException(
                        'User account not found during refund.'
                    );
                }

                $user->wallet_balance =
                    (float) $user->wallet_balance
                    + $amount;

                $user->save();
            }
        );
    }

    /**
     * Requery transaction.
     */
    public function requery(
        string $requestId
    ): JsonResponse {

        $transaction =
            CableTvTransaction::where(
                'request_id',
                $requestId
            )
            ->where(
                'user_id',
                auth()->id()
            )
            ->firstOrFail();

        try {

            $response =
                $this->vtpass->requery(
                    $requestId
                );

            $status = strtolower(
                data_get(
                    $response,
                    'content.transactions.status',
                    ''
                )
            );

            $transaction->update([
                'api_response' => $response,

                'vtpass_transaction_id' =>
                    data_get(
                        $response,
                        'content.transactions.transactionId'
                    ),
            ]);

            if (
                in_array(
                    $status,
                    [
                        'delivered',
                        'successful',
                    ],
                    true
                )
            ) {

                $transaction->update([
                    'status' => 'delivered',

                    'purchased_at' => now(),

                    'response_message' =>
                        'Transaction successful.',
                ]);
            }

            return response()->json([
                'success' => true,

                'status' =>
                    $status ?: $transaction->status,

                'message' =>
                    $response[
                        'response_description'
                    ]
                    ?? 'Transaction status retrieved.',
            ]);

        } catch (Throwable $e) {

            return response()->json([
                'success' => false,

                'message' =>
                    $e->getMessage(),
            ], 422);
        }
    }
}

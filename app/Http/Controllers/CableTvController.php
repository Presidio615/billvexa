<?php

namespace App\Http\Controllers;

use App\Models\CableTvTransaction;
use App\Models\Transaction;
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

        return view(
            'BillVexa.Dashboard.Quick.cable',
            compact('transactions')
        );
    }

    /**
     * Get plans for selected provider.
     */
    public function plans(Request $request): JsonResponse
    {
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
    public function verify(Request $request): JsonResponse
    {
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
    public function purchase(Request $request): JsonResponse
    {
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
         * Generate unique VTpass request ID.
         */
        $requestId = $this->vtpass->generateRequestId()
            . strtoupper(Str::random(8));

        /*
         * Create the service transaction and
         * general transaction ONLY after the
         * wallet has been successfully debited.
         */
        try {

            $transaction = DB::transaction(
                function () use (
                    $user,
                    $validated,
                    $amount,
                    $requestId
                ) {

                    $lockedUser = $user
                        ->newQuery()
                        ->where('id', $user->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$lockedUser) {
                        throw new \RuntimeException(
                            'User account not found.'
                        );
                    }

                    $balance = (float)
                        $lockedUser->wallet_balance;

                    if ($balance < $amount) {
                        throw new \RuntimeException(
                            'Insufficient wallet balance.'
                        );
                    }

                    /*
                     * Deduct wallet.
                     */
                    $lockedUser->wallet_balance =
                        $balance - $amount;

                    $lockedUser->save();

                    /*
                     * Create Cable TV transaction.
                     */
                    $cableTransaction =
                        CableTvTransaction::create([
                            'user_id' =>
                                $lockedUser->id,

                            'request_id' =>
                                $requestId,

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

                            'amount' =>
                                $amount,

                            'status' =>
                                'pending',
                        ]);

                    /*
                     * Create GENERAL transaction.
                     *
                     * This record appears in:
                     *
                     * User Transaction History
                     * Admin Transaction Management
                     */
                    Transaction::create([
                        'user_id' =>
                            $lockedUser->id,

                        'type' =>
                            'debit',

                        'service' =>
                            'Cable TV',

                        'network' =>
                            strtoupper(
                                $validated['provider']
                            ),

                        'phone' =>
                            $lockedUser->phone
                            ?? $lockedUser->phone_number
                            ?? null,

                        'amount' =>
                            $amount,

                        'status' =>
                            'pending',

                        'reference' =>
                            $requestId,

                        'discount' =>
                            0,

                        'profit' =>
                            0,

                        'total' =>
                            $amount,
                    ]);

                    return $cableTransaction;
                }
            );

        } catch (\RuntimeException $e) {

            return response()->json([
                'success' => false,

                'message' =>
                    $e->getMessage(),
            ], 422);
        }

        /*
         * Send purchase request to VTpass.
         */
        try {

            $payload = [
                'request_id' =>
                    $requestId,

                'serviceID' =>
                    $validated['provider'],

                'billersCode' =>
                    $validated['smart_card'],

                'variation_code' =>
                    $validated['variation_code'],

                'amount' =>
                    $amount,

                'phone' =>
                    $user->phone
                    ?? $user->phone_number
                    ?? '08000000000',

                'subscription_type' =>
                    'change',
            ];

            $response =
                $this->vtpass->purchase($payload);

            /*
             * Get VTpass transaction.
             */
            $vtpassTransaction =
                $response['content']['transactions']
                ?? [];

            $transactionId =
                $vtpassTransaction['transactionId']
                ?? null;

            $status =
                strtolower(
                    $vtpassTransaction['status']
                    ?? ''
                );

            /*
             * Update service transaction
             * with VTpass response.
             */
            $transaction->update([
                'api_response' =>
                    $response,

                'vtpass_transaction_id' =>
                    $transactionId,
            ]);

            /*
             * Find GENERAL transaction.
             *
             * IMPORTANT:
             * We update the existing record.
             *
             * We DO NOT create another one.
             */
            $generalTransaction =
                Transaction::where(
                    'reference',
                    $requestId
                )
                    ->where(
                        'user_id',
                        $user->id
                    )
                    ->first();

            /*
             * SUCCESS
             */
            if (
                ($response['code'] ?? null) === '000'
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
                    'status' =>
                        'delivered',

                    'customer_name' =>
                        $customerName,

                    'response_message' =>
                        $response[
                            'response_description'
                        ]
                        ?? 'Cable TV subscription successful.',

                    'purchased_at' =>
                        now(),
                ]);

                /*
                 * Update GENERAL transaction.
                 */
                if ($generalTransaction) {

                    $generalTransaction->update([
                        'status' =>
                            'successful',
                    ]);
                }

                return response()->json([
                    'success' =>
                        true,

                    'status' =>
                        'delivered',

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
             * PENDING
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
                    'status' =>
                        'pending',

                    'response_message' =>
                        $response[
                            'response_description'
                        ]
                        ?? 'Transaction is processing.',
                ]);

                /*
                 * Keep GENERAL transaction pending.
                 */
                if ($generalTransaction) {

                    $generalTransaction->update([
                        'status' =>
                            'pending',
                    ]);
                }

                return response()->json([
                    'success' =>
                        true,

                    'status' =>
                        'pending',

                    'message' =>
                        'Your cable TV transaction is being processed.',

                    'reference' =>
                        $requestId,
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
                'status' =>
                    'refunded',

                'response_message' =>
                    $response[
                        'response_description'
                    ]
                    ?? 'Cable TV transaction failed.',
            ]);

            /*
             * General transaction becomes
             * REFUNDED because the wallet
             * has actually been refunded.
             */
            if ($generalTransaction) {

                $generalTransaction->update([
                    'status' =>
                        'refunded',
                ]);
            }

            return response()->json([
                'success' =>
                    false,

                'status' =>
                    'refunded',

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
             * Try VTpass requery before refunding.
             */
            try {

                $requery =
                    $this->vtpass->requery(
                        $requestId
                    );

                $requeryStatus =
                    strtolower(
                        data_get(
                            $requery,
                            'content.transactions.status',
                            ''
                        )
                    );

                $generalTransaction =
                    Transaction::where(
                        'reference',
                        $requestId
                    )
                        ->where(
                            'user_id',
                            $user->id
                        )
                        ->first();

                /*
                 * VTpass delivered.
                 */
                if (
                    in_array(
                        $requeryStatus,
                        [
                            'delivered',
                            'successful',
                        ],
                        true
                    )
                ) {

                    $transaction->update([
                        'status' =>
                            'delivered',

                        'api_response' =>
                            $requery,

                        'vtpass_transaction_id' =>
                            data_get(
                                $requery,
                                'content.transactions.transactionId'
                            ),

                        'purchased_at' =>
                            now(),

                        'response_message' =>
                            'Cable TV subscription successful.',
                    ]);

                    if ($generalTransaction) {

                        $generalTransaction->update([
                            'status' =>
                                'successful',
                        ]);
                    }

                    return response()->json([
                        'success' =>
                            true,

                        'status' =>
                            'delivered',

                        'message' =>
                            'Cable TV subscription successful.',
                    ]);
                }

                /*
                 * Still pending.
                 */
                if (
                    in_array(
                        $requeryStatus,
                        [
                            'pending',
                            'processing',
                        ],
                        true
                    )
                ) {

                    $transaction->update([
                        'status' =>
                            'pending',

                        'api_response' =>
                            $requery,

                        'response_message' =>
                            'Transaction is still being processed.',
                    ]);

                    if ($generalTransaction) {

                        $generalTransaction->update([
                            'status' =>
                                'pending',
                        ]);
                    }

                    return response()->json([
                        'success' =>
                            true,

                        'status' =>
                            'pending',

                        'message' =>
                            'Your cable TV transaction is still being processed.',
                    ], 202);
                }

                /*
                 * VTpass confirmed failure.
                 *
                 * Refund wallet.
                 */
                $this->refundWallet(
                    $user->id,
                    $amount
                );

                $transaction->update([
                    'status' =>
                        'refunded',

                    'api_response' =>
                        $requery,

                    'response_message' =>
                        'Transaction failed. Wallet refunded.',
                ]);

                if ($generalTransaction) {

                    $generalTransaction->update([
                        'status' =>
                            'refunded',
                    ]);
                }

                return response()->json([
                    'success' =>
                        false,

                    'status' =>
                        'refunded',

                    'message' =>
                        'Cable TV transaction failed. Your wallet has been refunded.',
                ], 422);

            } catch (Throwable $requeryException) {

                /*
                 * We cannot confirm the result.
                 *
                 * DO NOT refund yet.
                 *
                 * Keep both records pending.
                 */
                Log::warning(
                    'Cable TV transaction status unknown',
                    [
                        'request_id' =>
                            $requestId,

                        'error' =>
                            $requeryException->getMessage(),
                    ]
                );

                $transaction->update([
                    'status' =>
                        'pending',

                    'response_message' =>
                        'Transaction status is being checked.',
                ]);

                $generalTransaction =
                    Transaction::where(
                        'reference',
                        $requestId
                    )
                        ->where(
                            'user_id',
                            $user->id
                        )
                        ->first();

                if ($generalTransaction) {

                    $generalTransaction->update([
                        'status' =>
                            'pending',
                    ]);
                }

                return response()->json([
                    'success' =>
                        false,

                    'status' =>
                        'pending',

                    'message' =>
                        'We could not confirm the transaction yet. Please check your transaction history.',
                ], 202);
            }
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
                    ->where(
                        'id',
                        $userId
                    )
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

        /*
         * Find GENERAL transaction.
         */
        $generalTransaction =
            Transaction::where(
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
                $this->vtpass->requery(
                    $requestId
                );

            $status =
                strtolower(
                    data_get(
                        $response,
                        'content.transactions.status',
                        ''
                    )
                );

            $transaction->update([
                'api_response' =>
                    $response,

                'vtpass_transaction_id' =>
                    data_get(
                        $response,
                        'content.transactions.transactionId'
                    ),
            ]);

            /*
             * SUCCESSFUL
             */
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
                    'status' =>
                        'delivered',

                    'purchased_at' =>
                        $transaction->purchased_at
                        ?? now(),

                    'response_message' =>
                        'Transaction successful.',
                ]);

                if ($generalTransaction) {

                    $generalTransaction->update([
                        'status' =>
                            'successful',
                    ]);
                }

                return response()->json([
                    'success' =>
                        true,

                    'status' =>
                        'delivered',

                    'message' =>
                        'Cable TV transaction successful.',
                ]);
            }

            /*
             * FAILED
             */
            if (
                in_array(
                    $status,
                    [
                        'failed',
                        'reversed',
                        'cancelled',
                    ],
                    true
                )
                &&
                $transaction->status !== 'refunded'
            ) {

                $this->refundWallet(
                    $transaction->user_id,
                    (float) $transaction->amount
                );

                $transaction->update([
                    'status' =>
                        'refunded',

                    'response_message' =>
                        'Transaction failed. Wallet refunded.',
                ]);

                if ($generalTransaction) {

                    $generalTransaction->update([
                        'status' =>
                            'refunded',
                    ]);
                }

                return response()->json([
                    'success' =>
                        false,

                    'status' =>
                        'refunded',

                    'message' =>
                        'Transaction failed. Your wallet has been refunded.',
                ]);
            }

            /*
             * STILL PENDING
             */
            $transaction->update([
                'status' =>
                    'pending',

                'api_response' =>
                    $response,
            ]);

            if ($generalTransaction) {

                $generalTransaction->update([
                    'status' =>
                        'pending',
                ]);
            }

            return response()->json([
                'success' =>
                    true,

                'status' =>
                    'pending',

                'message' =>
                    'Transaction is still pending.',
            ]);

        } catch (Throwable $e) {

            Log::error(
                'Cable TV Transaction Requery Error',
                [
                    'request_id' =>
                        $requestId,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Unable to check transaction status.',
            ], 500);
        }
    }
}
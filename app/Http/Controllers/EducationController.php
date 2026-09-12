<?php

namespace App\Http\Controllers;

use App\Models\EducationTransaction;
use App\Models\Transaction;
use App\Services\VtpassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class EducationController extends Controller
{
    public function __construct(
        protected VtpassService $vtpass
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | EDUCATION PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = auth()->user();

        $transactions = EducationTransaction::where(
            'user_id',
            $user->id
        )
            ->latest()
            ->take(5)
            ->get();

        return view(
            'BillVexa.Dashboard.Quick.education',
            compact('transactions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDUCATION SERVICES
    |--------------------------------------------------------------------------
    */

    public function services()
    {
        try {
            $result = $this->vtpass->educationServices();

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);

        } catch (Throwable $e) {

            Log::error(
                'VTpass education services error',
                [
                    'error' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve education services.',
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EDUCATION VARIATIONS
    |--------------------------------------------------------------------------
    */

    public function variations(string $serviceId)
    {
        try {

            $serviceId = strtolower(trim($serviceId));

            $result = $this->vtpass->educationVariations(
                $serviceId
            );

            return response()->json([
                'success' => true,
                'data' => $result,
                'content' => $result['content'] ?? [],
            ]);

        } catch (Throwable $e) {

            Log::error(
                'VTpass education variations error',
                [
                    'service_id' => $serviceId,
                    'error' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | JAMB VERIFICATION
    |--------------------------------------------------------------------------
    */

    public function verifyJamb(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => [
                'required',
                'string',
                'max:100',
            ],

            'type' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        try {

            $result = $this->vtpass->verifyJamb(
                $validated['profile_id'],
                $validated['type']
            );

            return response()->json([
                'success' => true,
                'message' => 'JAMB profile verified successfully.',
                'data' => $result,
            ]);

        } catch (Throwable $e) {

            Log::error(
                'JAMB verification error',
                [
                    'profile_id' => $validated['profile_id'],
                    'error' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EDUCATION PURCHASE
    |--------------------------------------------------------------------------
    */

    public function purchase(Request $request)
    {
        $validated = $request->validate([

            'service_id' => [
                'required',
                'string',
                'in:jamb,waec,waec-registration',
            ],

            'variation_code' => [
                'required',
                'string',
                'max:100',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1',
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^0[7-9][0-1][0-9]{8}$/',
            ],

            'billers_code' => [
                'required',
                'string',
                'max:100',
            ],

            'quantity' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);

        $user = auth()->user();

        $amount = (float) $validated['amount'];

        $quantity = (int) ($validated['quantity'] ?? 1);

        /*
        |--------------------------------------------------------------------------
        | CHECK WALLET
        |--------------------------------------------------------------------------
        */

        if ((float) $user->wallet_balance < $amount) {

            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE REQUEST ID
        |--------------------------------------------------------------------------
        */

        $requestId = $this->vtpass->generateRequestId();


        /*
        |--------------------------------------------------------------------------
        | CREATE LOCAL TRANSACTIONS
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | We create BOTH:
        |
        | 1. EducationTransaction
        | 2. General Transaction
        |
        | at the same time as the wallet deduction.
        |
        | The general transaction starts as "pending".
        |
        */

        try {

            $transaction = DB::transaction(function () use (
                $user,
                $validated,
                $amount,
                $requestId
            ) {

                /*
                |--------------------------------------------------------------------------
                | LOCK USER
                |--------------------------------------------------------------------------
                */

                $lockedUser = $user->newQuery()
                    ->whereKey($user->id)
                    ->lockForUpdate()
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | CHECK WALLET AGAIN
                |--------------------------------------------------------------------------
                */

                if (
                    (float) $lockedUser->wallet_balance < $amount
                ) {
                    throw new \RuntimeException(
                        'Insufficient wallet balance.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | DEDUCT WALLET
                |--------------------------------------------------------------------------
                */

                $lockedUser->decrement(
                    'wallet_balance',
                    $amount
                );


                /*
                |--------------------------------------------------------------------------
                | CREATE EDUCATION TRANSACTION
                |--------------------------------------------------------------------------
                */

                $educationTransaction =
                    EducationTransaction::create([
                        'user_id' =>
                            $lockedUser->id,

                        'request_id' =>
                            $requestId,

                        'service_id' =>
                            $validated['service_id'],

                        'variation_code' =>
                            $validated['variation_code'],

                        'billers_code' =>
                            $validated['billers_code'],

                        'phone' =>
                            $validated['phone'],

                        'amount' =>
                            $amount,

                        'status' =>
                            'processing',
                    ]);


                /*
                |--------------------------------------------------------------------------
                | CREATE GENERAL TRANSACTION
                |--------------------------------------------------------------------------
                |
                | This is the record used by:
                |
                | User Transaction History
                | Admin Transaction Dashboard
                |
                */

                Transaction::create([
                    'user_id' =>
                        $lockedUser->id,

                    'type' =>
                        'debit',

                    'service' =>
                        'Education',

                    'network' =>
                        strtoupper(
                            $validated['service_id']
                        ),

                    'phone' =>
                        $validated['phone'],

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


                return $educationTransaction;
            });

        } catch (Throwable $e) {

            Log::error(
                'Education wallet reservation failed',
                [
                    'user_id' =>
                        $user->id,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CALL VTPASS
        |--------------------------------------------------------------------------
        */

        try {

            $result = $this->vtpass->educationPurchase(

                $validated['service_id'],

                $validated['billers_code'],

                $validated['variation_code'],

                $amount,

                $validated['phone'],

                $requestId
            );

        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | CONNECTION ERROR
            |--------------------------------------------------------------------------
            |
            | DO NOT REFUND YET.
            |
            | VTpass may have received the request.
            |
            | Keep both transactions pending.
            |
            */

            $transaction->update([
                'status' => 'pending',

                'response' => [
                    'error' =>
                        $e->getMessage(),

                    'request_id' =>
                        $requestId,
                ],
            ]);


            $this->updateGeneralTransaction(
                $user->id,
                $requestId,
                'pending'
            );


            Log::error(
                'VTpass education purchase connection error',
                [
                    'user_id' =>
                        $user->id,

                    'request_id' =>
                        $requestId,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([
                'success' => false,

                'message' =>
                    'Your payment is being processed. Please check your transaction history shortly.',

                'status' =>
                    'pending',

                'request_id' =>
                    $requestId,

            ], 202);
        }


        /*
        |--------------------------------------------------------------------------
        | VTPASS RESPONSE
        |--------------------------------------------------------------------------
        */

        $code =
            $result['code']
            ?? null;


        $responseDescription =
            $result['response_description']
            ?? $result['message']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | VTPASS TRANSACTION ID
        |--------------------------------------------------------------------------
        */

        $vtpassTransactionId =
            data_get(
                $result,
                'content.transactions.transactionId'
            );


        if (!$vtpassTransactionId) {

            $vtpassTransactionId =
                data_get(
                    $result,
                    'content.transactionId'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | PURCHASED CODE / PIN
        |--------------------------------------------------------------------------
        */

        $purchasedCode =
            $result['purchased_code']
            ?? data_get(
                $result,
                'content.purchased_code'
            )
            ?? data_get(
                $result,
                'content.transactions.purchased_code'
            )
            ?? $result['Pin']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | SUCCESS
        |--------------------------------------------------------------------------
        */

        if ($code === '000') {

            $transaction->update([

                'status' =>
                    'successful',

                'vtpass_transaction_id' =>
                    $vtpassTransactionId,

                'purchased_code' =>
                    $purchasedCode,

                'response' =>
                    $result,

            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE GENERAL TRANSACTION
            |--------------------------------------------------------------------------
            */

            $this->updateGeneralTransaction(
                $user->id,
                $requestId,
                'successful'
            );


            return response()->json([

                'success' => true,

                'message' =>
                    'Education service purchased successfully.',

                'status' =>
                    'successful',

                'transaction' =>
                    $transaction->fresh(),

                'purchased_code' =>
                    $purchasedCode,

                'response' =>
                    $result,

                'receipt_url' => route(
                    'transaction.receipt',
                    $transaction
                ),

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | PENDING
        |--------------------------------------------------------------------------
        */

        $pendingCodes = [
            '099',
            '100',
            '001',
        ];


        if (
            in_array(
                (string) $code,
                $pendingCodes,
                true
            )
        ) {

            $transaction->update([

                'status' =>
                    'pending',

                'vtpass_transaction_id' =>
                    $vtpassTransactionId,

                'response' =>
                    $result,

            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE EXISTING GENERAL TRANSACTION
            |--------------------------------------------------------------------------
            */

            $this->updateGeneralTransaction(
                $user->id,
                $requestId,
                'pending'
            );


            return response()->json([

                'success' => false,

                'message' =>
                    $responseDescription
                    ?? 'Your transaction is being processed.',

                'status' =>
                    'pending',

                'request_id' =>
                    $requestId,

                'transaction' =>
                    $transaction->fresh(),

            ], 202);
        }


        /*
        |--------------------------------------------------------------------------
        | FAILED
        |--------------------------------------------------------------------------
        */

        $transaction->update([

            'status' =>
                'failed',

            'vtpass_transaction_id' =>
                $vtpassTransactionId,

            'response' =>
                $result,

        ]);


        /*
        |--------------------------------------------------------------------------
        | REFUND WALLET
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(function () use (
                $user,
                $amount
            ) {

                $lockedUser =
                    $user->newQuery()
                        ->whereKey($user->id)
                        ->lockForUpdate()
                        ->first();


                $lockedUser->increment(
                    'wallet_balance',
                    $amount
                );
            });

        } catch (Throwable $e) {

            Log::critical(
                'EDUCATION REFUND FAILED',
                [
                    'user_id' =>
                        $user->id,

                    'amount' =>
                        $amount,

                    'request_id' =>
                        $requestId,

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([

                'success' => false,

                'message' =>
                    'The education purchase failed, but the wallet refund requires review by an administrator.',

                'request_id' =>
                    $requestId,

            ], 500);
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE GENERAL TRANSACTION
        |--------------------------------------------------------------------------
        |
        | Wallet has actually been refunded, therefore the
        | general transaction becomes "refunded".
        |
        */

        $this->updateGeneralTransaction(
            $user->id,
            $requestId,
            'refunded'
        );


        return response()->json([

            'success' => false,

            'message' =>
                $responseDescription
                ?? 'Education purchase failed. Your wallet has been refunded.',

            'status' =>
                'failed',

            'refunded' =>
                true,

            'request_id' =>
                $requestId,

            'response' =>
                $result,

        ], 422);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE GENERAL TRANSACTION
    |--------------------------------------------------------------------------
    */

    private function updateGeneralTransaction(
        int $userId,
        string $requestId,
        string $status
    ): void {

        $generalTransaction =
            Transaction::where(
                'user_id',
                $userId
            )
            ->where(
                'reference',
                $requestId
            )
            ->first();


        if ($generalTransaction) {

            $generalTransaction->update([
                'status' => $status,
            ]);

        } else {

            /*
            |--------------------------------------------------------------------------
            | SAFETY FALLBACK
            |--------------------------------------------------------------------------
            |
            | This should normally never happen because the general
            | transaction is created together with the education
            | transaction.
            |
            | But if an older transaction does not have a general
            | record, create one so history is not lost.
            |
            */

            Log::warning(
                'General education transaction not found',
                [
                    'user_id' =>
                        $userId,

                    'request_id' =>
                        $requestId,
                ]
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RECENT TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    public function transactions()
    {
        $transactions =
            EducationTransaction::where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->take(10)
            ->get();


        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }
}
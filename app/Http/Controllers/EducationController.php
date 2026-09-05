<?php

namespace App\Http\Controllers;

use App\Models\EducationTransaction;
use App\Services\VtpassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    /**
     * Display Education page.
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

    /**
     * Get available education services from VTpass.
     *
     * Example:
     * jamb
     * waec
     * waec-registration
     */
    public function services()
    {
        try {

            $result =
                $this->vtpass->educationServices();

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
                'message' =>
                    'Unable to retrieve education services.',
            ], 500);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EDUCATION VARIATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get education plans/variations.
     */
    public function variations(string $serviceId)
    {
        try {

            $serviceId =
                strtolower(trim($serviceId));

            $result =
                $this->vtpass->educationVariations(
                    $serviceId
                );

            return response()->json([
                'success' => true,

                /*
                 * Keep VTpass response available
                 * to the frontend.
                 */
                'data' => $result,

                /*
                 * Also expose content directly
                 * for easier JavaScript handling.
                 */
                'content' =>
                    $result['content'] ?? [],
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
                'message' =>
                    $e->getMessage(),
            ], 422);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | JAMB VERIFICATION
    |--------------------------------------------------------------------------
    */

    /**
     * Verify JAMB profile/candidate.
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

            $result =
                $this->vtpass->verifyJamb(
                    $validated['profile_id'],
                    $validated['type']
                );

            return response()->json([
                'success' => true,
                'message' =>
                    'JAMB profile verified successfully.',
                'data' => $result,
            ]);

        } catch (Throwable $e) {

            Log::error(
                'JAMB verification error',
                [
                    'profile_id' =>
                        $validated['profile_id'],

                    'error' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' =>
                    $e->getMessage(),
            ], 422);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EDUCATION PURCHASE
    |--------------------------------------------------------------------------
    */

    /**
     * Purchase an education service.
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

        $amount =
            (float) $validated['amount'];

        $quantity =
            (int) ($validated['quantity'] ?? 1);


        /*
        |--------------------------------------------------------------------------
        | CHECK WALLET
        |--------------------------------------------------------------------------
        */

        if (
            (float) $user->wallet_balance
            < $amount
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Insufficient wallet balance.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE REQUEST ID
        |--------------------------------------------------------------------------
        */

        $requestId =
            $this->vtpass->generateRequestId();


        /*
        |--------------------------------------------------------------------------
        | CREATE LOCAL TRANSACTION
        |--------------------------------------------------------------------------
        */

        try {

            $transaction =
                DB::transaction(function () use (
                    $user,
                    $validated,
                    $amount,
                    $requestId
                ) {

                    /*
                     * Lock the user row to prevent
                     * simultaneous purchases from
                     * spending the same wallet balance.
                     */
                    $lockedUser =
                        $user->newQuery()
                            ->whereKey($user->id)
                            ->lockForUpdate()
                            ->first();


                    if (
                        (float) $lockedUser->wallet_balance
                        < $amount
                    ) {

                        throw new \RuntimeException(
                            'Insufficient wallet balance.'
                        );
                    }


                    /*
                     * Deduct wallet.
                     */
                    $lockedUser->decrement(
                        'wallet_balance',
                        $amount
                    );


                    /*
                     * Create local transaction.
                     */
                    return EducationTransaction::create([
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
                'message' =>
                    $e->getMessage(),
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | CALL VTPASS
        |--------------------------------------------------------------------------
        */

        try {

            $result =
                $this->vtpass->educationPurchase(

                    $validated['service_id'],

                    $validated['billers_code'],

                    $validated['variation_code'],

                    $amount,

                    $validated['phone'],

                    $requestId

                );


        } catch (Throwable $e) {

            /*
             * IMPORTANT:
             *
             * We do NOT immediately refund here.
             *
             * VTpass may have received/processed the
             * request even if our HTTP connection failed.
             *
             * Mark it for requery instead.
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
        | TRANSACTION ID
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
        | REFUND FAILED TRANSACTION
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

            /*
             * The purchase failed but refund also failed.
             *
             * This must be logged for admin
             * reconciliation.
             */

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
    | RECENT TRANSACTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Return recent education transactions.
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


<?php

namespace App\Http\Controllers;

use App\Models\ElectricityTransaction;
use App\Models\Transaction;
use App\Models\User;
use App\Services\VtpassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ElectricityController extends Controller
{
    public function __construct(
        protected VtpassService $vtpass
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | ELECTRICITY DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $transactions = ElectricityTransaction::where(
            'user_id',
            auth()->id()
        )
            ->latest()
            ->take(10)
            ->get();

        return view(
            'Billvexa.Dashboard.Quick.Electricity',
            compact('transactions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY METER
    |--------------------------------------------------------------------------
    */

    public function verifyMeter(Request $request)
    {
        $validated = $request->validate([
            'provider' => [
                'required',
                'in:IKEDC,EKEDC,AEDC,KEDCO,PHEDC,JEDC,KAEDCO,EEDC,IBEDC,BEDC,YEDC',
            ],

            'meter_type' => [
                'required',
                'in:prepaid,postpaid',
            ],

            'meter_number' => [
                'required',
                'string',
                'min:5',
                'max:30',
            ],
        ]);


        $serviceIds = [
            'IKEDC'  => 'ikeja-electric',
            'EKEDC'  => 'eko-electric',
            'AEDC'   => 'abuja-electric',
            'KEDCO'  => 'kano-electric',
            'PHEDC'  => 'portharcourt-electric',
            'JEDC'   => 'jos-electric',
            'KAEDCO' => 'kaduna-electric',
            'EEDC'   => 'enugu-electric',
            'IBEDC'  => 'ibadan-electric',
            'BEDC'   => 'benin-electric',
            'YEDC'   => 'yola-electric',
        ];


        $serviceId =
            $serviceIds[$validated['provider']];


        try {

            $response =
                $this->vtpass->verifyElectricityMeter(
                    $serviceId,
                    $validated['meter_number'],
                    $validated['meter_type']
                );


            $content =
                $response['content'] ?? [];


            return response()->json([
                'success' => true,

                'customer_name' =>
                    $content['Customer_Name']
                    ?? $content['customerName']
                    ?? '',

                'customer_address' =>
                    $content['Address']
                    ?? '',

                'meter_number' =>
                    $content['Meter_Number']
                    ?? $content['MeterNumber']
                    ?? $validated['meter_number'],

                'minimum_amount' =>
                    $content['Min_Purchase_Amount']
                    ?? $content['Minimum_Amount']
                    ?? 0,

                'meter_type' =>
                    $content['Meter_Type']
                    ?? strtoupper(
                        $validated['meter_type']
                    ),

                'can_vend' =>
                    $content['Can_Vend']
                    ?? 'yes',

                'data' =>
                    $content,
            ]);

        } catch (Throwable $e) {

            Log::error(
                'Electricity meter verification failed',
                [
                    'user_id' =>
                        auth()->id(),

                    'provider' =>
                        $validated['provider'],

                    'meter_number' =>
                        $validated['meter_number'],

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([
                'success' => false,

                'message' =>
                    $e->getMessage()
                    ?: 'Unable to verify meter.',
            ], 422);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PURCHASE ELECTRICITY
    |--------------------------------------------------------------------------
    */

    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'provider' => [
                'required',
                'in:IKEDC,EKEDC,AEDC,KEDCO,PHEDC,JEDC,KAEDCO,EEDC,IBEDC,BEDC,YEDC',
            ],

            'meter_type' => [
                'required',
                'in:prepaid,postpaid',
            ],

            'meter_number' => [
                'required',
                'string',
                'min:5',
                'max:30',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:500',
                'max:1000000',
            ],

            'phone' => [
                'required',
                'regex:/^[0-9]{10,15}$/',
            ],

            'customer_name' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | SERVICE IDs
        |--------------------------------------------------------------------------
        */

        $serviceIds = [
            'IKEDC'  => 'ikeja-electric',
            'EKEDC'  => 'eko-electric',
            'AEDC'   => 'abuja-electric',
            'KEDCO'  => 'kano-electric',
            'PHEDC'  => 'portharcourt-electric',
            'JEDC'   => 'jos-electric',
            'KAEDCO' => 'kaduna-electric',
            'EEDC'   => 'enugu-electric',
            'IBEDC'  => 'ibadan-electric',
            'BEDC'   => 'benin-electric',
            'YEDC'   => 'yola-electric',
        ];


        $provider =
            $validated['provider'];

        $serviceId =
            $serviceIds[$provider];

        $amount =
            (float) $validated['amount'];


        /*
        |--------------------------------------------------------------------------
        | DISCOUNT
        |--------------------------------------------------------------------------
        */

        $discount = 0;

        if (config('services.electricity.discount')) {

            $discount =
                (float) config(
                    'services.electricity.discount'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $total =
            max(
                0,
                $amount - $discount
            );


        /*
        |--------------------------------------------------------------------------
        | GENERATE REQUEST ID
        |--------------------------------------------------------------------------
        */

        $requestId =
            $this->vtpass->generateRequestId();


        /*
        |--------------------------------------------------------------------------
        | DEDUCT WALLET + CREATE LOCAL TRANSACTIONS
        |--------------------------------------------------------------------------
        |
        | Two records are created together:
        |
        | 1. ElectricityTransaction
        | 2. General Transaction
        |
        | The general transaction starts as "pending".
        |
        */

        try {

            $transaction =
                DB::transaction(function () use (
                    $requestId,
                    $provider,
                    $serviceId,
                    $validated,
                    $amount,
                    $discount,
                    $total
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | LOCK USER
                    |--------------------------------------------------------------------------
                    */

                    $user =
                        User::whereKey(
                            auth()->id()
                        )
                        ->lockForUpdate()
                        ->firstOrFail();


                    /*
                    |--------------------------------------------------------------------------
                    | CHECK WALLET
                    |--------------------------------------------------------------------------
                    */

                    if (
                        (float) $user->wallet_balance
                        < $total
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

                    $user->wallet_balance =
                        (float) $user->wallet_balance
                        - $total;

                    $user->save();


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE ELECTRICITY TRANSACTION
                    |--------------------------------------------------------------------------
                    */

                    $electricityTransaction =
                        ElectricityTransaction::create([
                            'user_id' =>
                                $user->id,

                            'request_id' =>
                                $requestId,

                            'provider' =>
                                $provider,

                            'service_id' =>
                                $serviceId,

                            'meter_number' =>
                                $validated['meter_number'],

                            'meter_type' =>
                                $validated['meter_type'],

                            'customer_name' =>
                                $validated['customer_name']
                                ?? null,

                            'amount' =>
                                $amount,

                            'discount' =>
                                $discount,

                            'total' =>
                                $total,

                            'phone' =>
                                $validated['phone'],

                            'status' =>
                                'pending',
                        ]);


                    /*
                    |--------------------------------------------------------------------------
                    | CREATE GENERAL TRANSACTION
                    |--------------------------------------------------------------------------
                    |
                    | This is what the user transaction history
                    | and admin transaction dashboard use.
                    |
                    */

                    Transaction::create([
                        'user_id' =>
                            $user->id,

                        'type' =>
                            'debit',

                        'service' =>
                            'Electricity',

                        'network' =>
                            $provider,

                        'phone' =>
                            $validated['phone'],

                        'amount' =>
                            $amount,

                        'status' =>
                            'pending',

                        'reference' =>
                            $requestId,

                        'discount' =>
                            $discount,

                        'profit' =>
                            0,

                        'total' =>
                            $total,
                    ]);


                    return $electricityTransaction;
                });


        } catch (Throwable $e) {

            Log::error(
                'Electricity wallet reservation failed',
                [
                    'user_id' =>
                        auth()->id(),

                    'request_id' =>
                        $requestId,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SEND PAYMENT TO VTPASS
        |--------------------------------------------------------------------------
        */

        try {

            $response =
                $this->vtpass->electricityPurchase(
                    $serviceId,
                    $validated['meter_number'],
                    $validated['meter_type'],
                    $amount,
                    $validated['phone'],
                    $requestId
                );


            $code =
                $response['code']
                ?? null;


            $transactionData =
                $response['content']['transactions']
                ?? [];


            $status =
                strtolower(
                    (string) (
                        $transactionData['status']
                        ?? ''
                    )
                );


            $vtpassTransactionId =
                $transactionData['transactionId']
                ?? $transactionData['transaction_id']
                ?? null;


            /*
            |--------------------------------------------------------------------------
            | PREPAID TOKEN
            |--------------------------------------------------------------------------
            */

            $token =
                $response['purchased_code']
                ?? $transactionData['purchased_code']
                ?? $transactionData['token']
                ?? null;


            $units =
                $transactionData['units']
                ?? $transactionData['unit']
                ?? null;


            /*
            |--------------------------------------------------------------------------
            | SUCCESS
            |--------------------------------------------------------------------------
            */

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

                $transaction->update([
                    'status' =>
                        'successful',

                    'token' =>
                        $token,

                    'units' =>
                        $units,

                    'vtpass_transaction_id' =>
                        $vtpassTransactionId,

                    'response_message' =>
                        $response['response_description']
                        ?? 'Electricity payment successful.',

                    'api_response' =>
                        $response,

                    'purchased_at' =>
                        now(),
                ]);


                /*
                |--------------------------------------------------------------------------
                | UPDATE GENERAL TRANSACTION
                |--------------------------------------------------------------------------
                */

                $this->updateGeneralTransaction(
                    $transaction->user_id,
                    $requestId,
                    'successful'
                );


                return redirect()
                    ->route('electricity')
                    ->with(
                        'success',
                        'Electricity payment successful.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | PENDING
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $status,
                    [
                        'pending',
                        'initiated',
                        'processing',
                    ],
                    true
                )
            ) {

                $transaction->update([
                    'status' =>
                        'pending',

                    'vtpass_transaction_id' =>
                        $vtpassTransactionId,

                    'response_message' =>
                        $response['response_description']
                        ?? 'Transaction is processing.',

                    'api_response' =>
                        $response,
                ]);


                /*
                |--------------------------------------------------------------------------
                | GENERAL TRANSACTION REMAINS PENDING
                |--------------------------------------------------------------------------
                */

                $this->updateGeneralTransaction(
                    $transaction->user_id,
                    $requestId,
                    'pending'
                );


                return redirect()
                    ->route('electricity')
                    ->with(
                        'warning',
                        'Your electricity payment is being processed.'
                    );
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

                'response_message' =>
                    $response['response_description']
                    ?? 'Electricity payment failed.',

                'api_response' =>
                    $response,
            ]);


            /*
            |--------------------------------------------------------------------------
            | REFUND WALLET
            |--------------------------------------------------------------------------
            */

            $this->refund(
                $transaction
            );


            /*
            |--------------------------------------------------------------------------
            | UPDATE GENERAL TRANSACTION
            |--------------------------------------------------------------------------
            |
            | Because the wallet has now been refunded,
            | the general transaction becomes "refunded".
            |
            */

            $this->updateGeneralTransaction(
                $transaction->user_id,
                $requestId,
                'refunded'
            );


            return redirect()
                ->route('electricity')
                ->with(
                    'error',
                    'Electricity payment failed. Your wallet has been refunded.'
                );


        } catch (Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | UNKNOWN RESULT
            |--------------------------------------------------------------------------
            |
            | DO NOT REFUND HERE.
            |
            | VTpass may have received the transaction.
            |
            */

            Log::error(
                'Electricity VTpass exception',
                [
                    'request_id' =>
                        $requestId,

                    'user_id' =>
                        auth()->id(),

                    'error' =>
                        $e->getMessage(),
                ]
            );


            $transaction->update([
                'status' =>
                    'pending',

                'response_message' =>
                    'Transaction outcome is being verified.',

                'api_response' => [
                    'error' =>
                        $e->getMessage(),
                ],
            ]);


            /*
            |--------------------------------------------------------------------------
            | GENERAL TRANSACTION REMAINS PENDING
            |--------------------------------------------------------------------------
            */

            $this->updateGeneralTransaction(
                $transaction->user_id,
                $requestId,
                'pending'
            );


            return redirect()
                ->route('electricity')
                ->with(
                    'warning',
                    'Your payment is being verified. Please check your transaction history.'
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | REQUERY TRANSACTION
    |--------------------------------------------------------------------------
    */

    public function requery(
        string $requestId
    ) {

        $transaction =
            ElectricityTransaction::where(
                'request_id',
                $requestId
            )
            ->where(
                'user_id',
                auth()->id()
            )
            ->firstOrFail();


        if (
            $transaction->status !== 'pending'
        ) {

            return back()->with(
                'info',
                'This transaction does not need verification.'
            );
        }


        try {

            $response =
                $this->vtpass->requery(
                    $requestId
                );


            $code =
                $response['code']
                ?? null;


            $transactionData =
                $response['content']['transactions']
                ?? [];


            $status =
                strtolower(
                    (string) (
                        $transactionData['status']
                        ?? ''
                    )
                );


            /*
            |--------------------------------------------------------------------------
            | REQUERY SUCCESS
            |--------------------------------------------------------------------------
            */

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

                $token =
                    $response['purchased_code']
                    ?? $transactionData['purchased_code']
                    ?? $transactionData['token']
                    ?? null;


                $units =
                    $transactionData['units']
                    ?? $transactionData['unit']
                    ?? null;


                $transaction->update([
                    'status' =>
                        'successful',

                    'token' =>
                        $token,

                    'units' =>
                        $units,

                    'vtpass_transaction_id' =>
                        $transactionData['transactionId']
                        ?? $transactionData['transaction_id']
                        ?? null,

                    'response_message' =>
                        'Electricity payment successful.',

                    'api_response' =>
                        $response,

                    'purchased_at' =>
                        now(),
                ]);


                /*
                |--------------------------------------------------------------------------
                | UPDATE GENERAL TRANSACTION
                |--------------------------------------------------------------------------
                */

                $this->updateGeneralTransaction(
                    $transaction->user_id,
                    $requestId,
                    'successful'
                );


                return back()->with(
                    'success',
                    'Electricity payment successful.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | REQUERY FAILED
            |--------------------------------------------------------------------------
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
            ) {

                $transaction->update([
                    'status' =>
                        'failed',

                    'response_message' =>
                        'Electricity payment failed.',

                    'api_response' =>
                        $response,
                ]);


                /*
                |--------------------------------------------------------------------------
                | REFUND
                |--------------------------------------------------------------------------
                */

                $this->refund(
                    $transaction
                );


                /*
                |--------------------------------------------------------------------------
                | UPDATE GENERAL TRANSACTION
                |--------------------------------------------------------------------------
                */

                $this->updateGeneralTransaction(
                    $transaction->user_id,
                    $requestId,
                    'refunded'
                );


                return back()->with(
                    'error',
                    'Payment failed. Your wallet has been refunded.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | STILL PROCESSING
            |--------------------------------------------------------------------------
            */

            $this->updateGeneralTransaction(
                $transaction->user_id,
                $requestId,
                'pending'
            );


            return back()->with(
                'warning',
                'The transaction is still processing.'
            );


        } catch (Throwable $e) {

            Log::error(
                'Electricity requery failed',
                [
                    'request_id' =>
                        $requestId,

                    'error' =>
                        $e->getMessage(),
                ]
            );


            return back()->with(
                'error',
                'Unable to verify the transaction right now.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE GENERAL TRANSACTION
    |--------------------------------------------------------------------------
    */

    protected function updateGeneralTransaction(
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
                'status' =>
                    $status,
            ]);

        } else {

            /*
            |--------------------------------------------------------------------------
            | SAFETY LOG
            |--------------------------------------------------------------------------
            |
            | We do not create another transaction here.
            | The transaction should already exist because it
            | was created during the wallet reservation.
            |
            */

            Log::warning(
                'General electricity transaction not found',
                [
                    'user_id' =>
                        $userId,

                    'request_id' =>
                        $requestId,

                    'status' =>
                        $status,
                ]
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | REFUND FAILED TRANSACTION
    |--------------------------------------------------------------------------
    */

    protected function refund(
        ElectricityTransaction $transaction
    ): void {

        DB::transaction(function () use (
            $transaction
        ) {

            /*
            |--------------------------------------------------------------------------
            | LOCK ELECTRICITY TRANSACTION
            |--------------------------------------------------------------------------
            */

            $transaction =
                ElectricityTransaction::whereKey(
                    $transaction->id
                )
                ->lockForUpdate()
                ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | PREVENT DUPLICATE REFUND
            |--------------------------------------------------------------------------
            */

            if (
                $transaction->response_message
                &&
                str_contains(
                    strtolower(
                        $transaction->response_message
                    ),
                    'wallet refunded'
                )
            ) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | LOCK USER
            |--------------------------------------------------------------------------
            */

            $user =
                User::whereKey(
                    $transaction->user_id
                )
                ->lockForUpdate()
                ->firstOrFail();


            /*
            |--------------------------------------------------------------------------
            | REFUND WALLET
            |--------------------------------------------------------------------------
            */

            $user->wallet_balance =
                (float) $user->wallet_balance
                + (float) $transaction->total;

            $user->save();


            /*
            |--------------------------------------------------------------------------
            | MARK REFUNDED
            |--------------------------------------------------------------------------
            */

            $transaction->update([
                'response_message' =>
                    ($transaction->response_message ?? '')
                    . ' Wallet refunded.',
            ]);
        });
    }
}

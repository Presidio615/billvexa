<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FlutterwaveVirtualAccountController extends Controller
{
    public function create(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Don't create another account if the user already has one
        |--------------------------------------------------------------------------
        */

        if ($user->account_number) {
            return response()->json([
                'status' => 'success',
                'message' => 'User already has a virtual account.',
                'data' => [
                    'account_number' => $user->account_number,
                    'bank_name' => $user->account_bank,
                ],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NIN/BVN is required for static NGN virtual accounts
        |--------------------------------------------------------------------------
        */

        $nin = $user->nin ?? null;
        $bvn = $user->bvn ?? null;

        if (!$nin && !$bvn) {
            return response()->json([
                'status' => 'error',
                'message' => 'User must have a verified NIN or BVN before a virtual account can be created.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Split user's name
        |--------------------------------------------------------------------------
        */

        $name = trim($user->name);

        $parts = preg_split('/\s+/', $name);

        $firstname = $parts[0] ?? 'Customer';

        $lastname = count($parts) > 1
            ? implode(' ', array_slice($parts, 1))
            : 'User';

        /*
        |--------------------------------------------------------------------------
        | Unique Flutterwave reference
        |--------------------------------------------------------------------------
        */

        $reference = 'BILLVEXA-VA-' .
            $user->id . '-' .
            strtoupper(Str::random(12));

        /*
        |--------------------------------------------------------------------------
        | Create static NGN virtual account
        |--------------------------------------------------------------------------
        */

        $payload = [
            'email' => $user->email,

            'tx_ref' => $reference,

            'currency' => 'NGN',

            'is_permanent' => true,

            'firstname' => $firstname,

            'lastname' => $lastname,

            'phonenumber' => $user->phone ?? null,

            'narration' => $name,
        ];

        /*
        |--------------------------------------------------------------------------
        | Add NIN or BVN
        |--------------------------------------------------------------------------
        */

        if ($nin) {
            $payload['nin'] = $nin;
        } elseif ($bvn) {
            $payload['bvn'] = $bvn;
        }

        /*
        |--------------------------------------------------------------------------
        | Flutterwave API
        |--------------------------------------------------------------------------
        */

        $response = Http::withToken(
            config('services.flutterwave.secret')
        )
            ->acceptJson()
            ->post(
                'https://api.flutterwave.com/v3/virtual-account-numbers',
                $payload
            );

        /*
        |--------------------------------------------------------------------------
        | Log failed response
        |--------------------------------------------------------------------------
        */

        if (!$response->successful()) {

            \Log::error(
                'Flutterwave virtual account creation failed',
                [
                    'user_id' => $user->id,
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Flutterwave could not create the virtual account.',
                'flutterwave_response' => $response->json(),
            ], $response->status());
        }

        $result = $response->json();

        /*
        |--------------------------------------------------------------------------
        | Make sure Flutterwave says success
        |--------------------------------------------------------------------------
        */

        if (($result['status'] ?? null) !== 'success') {

            return response()->json([
                'status' => 'error',
                'message' => $result['message']
                    ?? 'Virtual account creation failed.',
                'flutterwave_response' => $result,
            ], 422);
        }

        $data = $result['data'] ?? [];

        /*
        |--------------------------------------------------------------------------
        | Extract account details
        |--------------------------------------------------------------------------
        */

        $accountNumber =
            $data['accountnumber']
            ?? $data['account_number']
            ?? null;

        $bankName =
            $data['bankname']
            ?? $data['bank_name']
            ?? null;

        $accountId =
            $data['id']
            ?? $data['account_id']
            ?? null;

        if (!$accountNumber) {

            \Log::error(
                'Flutterwave returned no account number',
                [
                    'user_id' => $user->id,
                    'response' => $result,
                ]
            );

            return response()->json([
                'status' => 'error',
                'message' => 'Flutterwave did not return an account number.',
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Save account details
        |--------------------------------------------------------------------------
        */

        $user->update([
            'account_number' => $accountNumber,
            'account_bank' => $bankName,

            'flutterwave_account_reference' => $reference,

            'flutterwave_account_id' => $accountId,
        ]);

        return response()->json([
            'status' => 'success',

            'message' => 'Virtual account created successfully.',

            'data' => [
                'account_number' => $accountNumber,
                'bank_name' => $bankName,
                'reference' => $reference,
            ],
        ]);
    }
}
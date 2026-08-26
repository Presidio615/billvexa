<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FlutterwaveService
{
    public function createStaticVirtualAccount(User $user): array
    {
        if ($user->account_number) {
            return [
                'success' => true,
                'existing' => true,
                'account_number' => $user->account_number,
                'bank_name' => $user->account_bank,
            ];
        }

        $nin = $user->nin ?? null;
        $bvn = $user->bvn ?? null;

        if (!$nin && !$bvn) {
            return [
                'success' => false,
                'message' => 'NIN or BVN is required.',
            ];
        }

        $parts = preg_split(
            '/\s+/',
            trim($user->name)
        );

        $firstname = $parts[0] ?? 'Customer';

        $lastname = count($parts) > 1
            ? implode(
                ' ',
                array_slice($parts, 1)
            )
            : 'User';

        $reference =
            'BILLVEXA-VA-' .
            $user->id .
            '-' .
            strtoupper(Str::random(12));

        $payload = [
            'email' => $user->email,

            'tx_ref' => $reference,

            'currency' => 'NGN',

            'is_permanent' => true,

            'firstname' => $firstname,

            'lastname' => $lastname,

            'phonenumber' => $user->phone ?? null,

            'narration' => $user->name,
        ];

        if ($nin) {
            $payload['nin'] = $nin;
        } else {
            $payload['bvn'] = $bvn;
        }

        $response = Http::withToken(
            config('services.flutterwave.secret')
        )
            ->acceptJson()
            ->post(
                'https://api.flutterwave.com/v3/virtual-account-numbers',
                $payload
            );

        if (!$response->successful()) {

            Log::error(
                'Flutterwave virtual account error',
                [
                    'user_id' => $user->id,
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]
            );

            return [
                'success' => false,
                'message' => 'Flutterwave virtual account creation failed.',
                'response' => $response->json(),
            ];
        }

        $result = $response->json();

        if (($result['status'] ?? null) !== 'success') {

            return [
                'success' => false,
                'message' => $result['message']
                    ?? 'Virtual account creation failed.',
            ];
        }

        $data = $result['data'] ?? [];

        $accountNumber =
            $data['accountnumber']
            ?? $data['account_number']
            ?? null;

        $bankName =
            $data['bankname']
            ?? $data['bank_name']
            ?? null;

        if (!$accountNumber) {

            return [
                'success' => false,
                'message' => 'No account number was returned.',
            ];
        }

        $user->update([
            'account_number' => $accountNumber,

            'account_bank' => $bankName,

            'flutterwave_account_reference' => $reference,

            'flutterwave_account_id' =>
                $data['id'] ?? null,
        ]);

        return [
            'success' => true,

            'account_number' => $accountNumber,

            'bank_name' => $bankName,

            'reference' => $reference,
        ];
    }
}
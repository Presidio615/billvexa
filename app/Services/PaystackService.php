<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class PaystackService
{
    protected string $baseUrl = 'https://api.paystack.co';

    protected function request()
    {
        return Http::withToken(config('services.paystack.secret'))
            ->acceptJson()
            ->asJson();
    }

    /**
     * Create a Paystack customer.
     */
    public function createCustomer(
        string $email,
        string $firstName,
        string $lastName,
        ?string $phone = null
    ): array {
        $payload = [
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
        ];

        if ($phone) {
            $payload['phone'] = $phone;
        }

        $response = $this->request()->post(
            $this->baseUrl . '/customer',
            $payload
        );

        if (!$response->successful() || !$response->json('status')) {
            throw new RuntimeException(
                $response->json('message') ?? 'Unable to create Paystack customer.'
            );
        }

        return $response->json('data');
    }

    /**
     * Create a dedicated virtual account.
     *
     * Test mode uses test-bank.
     */
    public function createDedicatedAccount(
        string $customerCode,
        string $preferredBank = 'test-bank'
    ): array {
        $response = $this->request()->post(
            $this->baseUrl . '/dedicated_account',
            [
                'customer' => $customerCode,
                'preferred_bank' => $preferredBank,
            ]
        );

        if (!$response->successful() || !$response->json('status')) {
            throw new RuntimeException(
                $response->json('message') ?? 'Unable to create dedicated virtual account.'
            );
        }

        return $response->json('data');
    }

    /**
     * Get a Paystack customer.
     */
    public function getCustomer(string $customerCode): array
    {
        $response = $this->request()->get(
            $this->baseUrl . '/customer/' . urlencode($customerCode)
        );

        if (!$response->successful() || !$response->json('status')) {
            throw new RuntimeException(
                $response->json('message') ?? 'Unable to retrieve Paystack customer.'
            );
        }

        return $response->json('data');
    }
}
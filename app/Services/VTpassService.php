<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class VtpassService
{
    protected string $baseUrl;

    protected string $apiKey;

    protected string $publicKey;

    protected string $secretKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config('services.vtpass.base_url'),
            '/'
        );

        $this->apiKey = config('services.vtpass.api_key');

        $this->publicKey = config('services.vtpass.public_key');

        $this->secretKey = config('services.vtpass.secret_key');
    }

    /**
     * GET request.
     *
     * VTpass GET requests use:
     * api-key
     * public-key
     */
    protected function getRequest(): PendingRequest
    {
        return Http::acceptJson()
            ->timeout(30)
            ->withHeaders([
                'api-key' => $this->apiKey,
                'public-key' => $this->publicKey,
            ]);
    }

    /**
     * POST request.
     *
     * VTpass POST requests use:
     * api-key
     * secret-key
     */
    protected function postRequest(): PendingRequest
    {
        return Http::acceptJson()
            ->timeout(60)
            ->withHeaders([
                'api-key' => $this->apiKey,
                'secret-key' => $this->secretKey,
            ]);
    }

    /**
     * Generate a VTpass request ID.
     *
     * First 12 characters contain Lagos date/time.
     */
    public function generateRequestId(): string
    {
        return now('Africa/Lagos')->format('YmdHi')
            . strtoupper(Str::random(12));
    }

    /*
    |--------------------------------------------------------------------------
    | SERVICE VARIATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get VTpass service variations.
     *
     * Supports:
     * Cable TV
     * Data
     */
    public function variations(string $serviceId): array
    {
        $allowedServices = [
            // Cable TV
            'dstv',
            'gotv',
            'startimes',

            // Data
            'mtn-data',
            'glo-data',
            'airtel-data',
            'etisalat-data',
        ];

        if (!in_array($serviceId, $allowedServices, true)) {
            throw new RuntimeException(
                'Invalid VTpass service ID.'
            );
        }

        $response = $this->getRequest()
            ->get(
                $this->baseUrl . '/service-variations',
                [
                    'serviceID' => $serviceId,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'VTpass variations request failed: '
                . $response->body()
            );
        }

        $data = $response->json();

        if (($data['response_description'] ?? null) !== '000') {
            throw new RuntimeException(
                $data['response_description']
                    ?? 'Unable to retrieve VTpass variations.'
            );
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | CABLE TV
    |--------------------------------------------------------------------------
    */

    /**
     * Verify Smart Card / IUC number.
     */
    public function verify(
        string $serviceId,
        string $smartCard
    ): array {

        $allowed = [
            'dstv',
            'gotv',
            'startimes',
        ];

        if (!in_array($serviceId, $allowed, true)) {
            throw new RuntimeException(
                'Invalid cable TV provider.'
            );
        }

        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/merchant-verify',
                [
                    'billersCode' => $smartCard,
                    'serviceID' => $serviceId,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'Unable to connect to VTpass.'
            );
        }

        $data = $response->json();

        if (($data['code'] ?? null) !== '000') {
            throw new RuntimeException(
                $data['response_description']
                    ?? 'Invalid smart card number.'
            );
        }

        return $data['content'] ?? [];
    }

    /**
     * Purchase Cable TV subscription.
     */
    public function purchase(array $payload): array
    {
        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/pay',
                $payload
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'VTpass purchase request failed: '
                . $response->body()
            );
        }

        return $response->json();
    }

    /*
    |--------------------------------------------------------------------------
    | AIRTIME
    |--------------------------------------------------------------------------
    */

    /**
     * Purchase Airtime.
     *
     * Supported service IDs:
     *
     * mtn
     * glo
     * airtel
     * etisalat
     */
    public function airtimePurchase(
        string $serviceId,
        string $phone,
        float $amount,
        string $requestId
    ): array {

        $allowedServices = [
            'mtn',
            'glo',
            'airtel',
            'etisalat',
        ];

        if (!in_array($serviceId, $allowedServices, true)) {
            throw new RuntimeException(
                'Invalid airtime network.'
            );
        }

        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/pay',
                [
                    'request_id' => $requestId,

                    'serviceID' => $serviceId,

                    'billersCode' => $phone,

                    'phone' => $phone,

                    'amount' => $amount,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'VTpass airtime request failed: '
                . $response->body()
            );
        }

        return $response->json();
    }

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    /**
     * Purchase Data Bundle.
     */
    public function dataPurchase(
        string $serviceId,
        string $phone,
        string $variationCode,
        float $amount,
        string $requestId
    ): array {

        $allowedServices = [
            'mtn-data',
            'glo-data',
            'airtel-data',
            'etisalat-data',
        ];

        if (!in_array($serviceId, $allowedServices, true)) {
            throw new RuntimeException(
                'Invalid data network.'
            );
        }

        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/pay',
                [
                    'request_id' => $requestId,

                    'serviceID' => $serviceId,

                    'billersCode' => $phone,

                    'variation_code' => $variationCode,

                    'amount' => $amount,

                    'phone' => $phone,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'VTpass data purchase request failed: '
                . $response->body()
            );
        }

        return $response->json();
    }

        /*
    |--------------------------------------------------------------------------
    | ELECTRICITY
    |--------------------------------------------------------------------------
    */

    /**
     * Verify Electricity Meter.
     *
     * Supported providers:
     *
     * IKEDC
     * EKEDC
     * AEDC
     * KEDCO
     * PHEDC
     * JEDC
     * KAEDCO
     * EEDC
     * IBEDC
     * BEDC
     * YEDC
     */
    public function verifyElectricityMeter(
        string $serviceId,
        string $meterNumber,
        string $meterType
    ): array {

        $allowedServices = [
            'ikeja-electric',
            'eko-electric',
            'abuja-electric',
            'kano-electric',
            'portharcourt-electric',
            'jos-electric',
            'kaduna-electric',
            'enugu-electric',
            'ibadan-electric',
            'benin-electric',
            'yola-electric',
        ];

        if (!in_array($serviceId, $allowedServices, true)) {
            throw new RuntimeException(
                'Invalid electricity provider.'
            );
        }

        $type = strtolower($meterType);

        if (!in_array($type, ['prepaid', 'postpaid'], true)) {
            throw new RuntimeException(
                'Invalid meter type.'
            );
        }

        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/merchant-verify',
                [
                    'billersCode' => $meterNumber,

                    'serviceID' => $serviceId,

                    'type' => $type,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'Unable to connect to VTpass.'
            );
        }

        $data = $response->json();

        if (($data['code'] ?? null) !== '000') {
            throw new RuntimeException(
                $data['response_description']
                    ?? 'Unable to verify electricity meter.'
            );
        }

        return $data;
    }

    /**
     * Purchase Electricity.
     */
    public function electricityPurchase(
        string $serviceId,
        string $meterNumber,
        string $meterType,
        float $amount,
        string $phone,
        string $requestId
    ): array {

        $allowedServices = [
            'ikeja-electric',
            'eko-electric',
            'abuja-electric',
            'kano-electric',
            'portharcourt-electric',
            'jos-electric',
            'kaduna-electric',
            'enugu-electric',
            'ibadan-electric',
            'benin-electric',
            'yola-electric',
        ];

        if (!in_array($serviceId, $allowedServices, true)) {
            throw new RuntimeException(
                'Invalid electricity provider.'
            );
        }

        $type = strtolower($meterType);

        if (!in_array($type, ['prepaid', 'postpaid'], true)) {
            throw new RuntimeException(
                'Invalid meter type.'
            );
        }

        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/pay',
                [
                    'request_id' => $requestId,

                    'serviceID' => $serviceId,

                    'billersCode' => $meterNumber,

                    'variation_code' => $type,

                    'amount' => $amount,

                    'phone' => $phone,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'VTpass electricity request failed: '
                . $response->body()
            );
        }

        return $response->json();
    }

    /*
|--------------------------------------------------------------------------
| EDUCATION
|--------------------------------------------------------------------------
*/

/**
 * Get available education services from VTpass.
 *
 * Example:
 * JAMB
 * WAEC
 * WAEC Registration
 */
public function educationServices(): array
{
    $response = $this->getRequest()
        ->get(
            $this->baseUrl . '/services',
            [
                'identifier' => 'education',
            ]
        );

    if (!$response->successful()) {
        throw new RuntimeException(
            'Unable to retrieve education services: '
            . $response->body()
        );
    }

    $data = $response->json();

    if (($data['response_description'] ?? null) !== '000') {
        throw new RuntimeException(
            $data['response_description']
                ?? 'Unable to retrieve education services.'
        );
    }

    return $data;
}

/**
 * Get education service variations.
 *
 * Example:
 *
 * jamb
 * waec
 * waec-registration
 */
public function educationVariations(
    string $serviceId
): array {

    $allowedServices = [
        'jamb',
        'waec',
        'waec-registration',
    ];

    if (!in_array($serviceId, $allowedServices, true)) {
        throw new RuntimeException(
            'Invalid education service.'
        );
    }

    $response = $this->getRequest()
        ->get(
            $this->baseUrl . '/service-variations',
            [
                'serviceID' => $serviceId,
            ]
        );

    if (!$response->successful()) {
        throw new RuntimeException(
            'VTpass education variations request failed: '
            . $response->body()
        );
    }

    $data = $response->json();

    if (($data['response_description'] ?? null) !== '000') {
        throw new RuntimeException(
            $data['response_description']
                ?? 'Unable to retrieve education plans.'
        );
    }

    return $data;
}

/**
 * Verify JAMB profile.
 */
public function verifyJamb(
    string $profileId,
    string $type
): array {

    if ($type === '') {
        throw new RuntimeException(
            'JAMB verification type is required.'
        );
    }

    $response = $this->postRequest()
        ->post(
            $this->baseUrl . '/merchant-verify',
            [
                'billersCode' => $profileId,

                'serviceID' => 'jamb',

                'type' => $type,
            ]
        );

    if (!$response->successful()) {
        throw new RuntimeException(
            'Unable to connect to VTpass.'
        );
    }

    $data = $response->json();

    if (($data['code'] ?? null) !== '000') {
        throw new RuntimeException(
            $data['response_description']
                ?? 'Unable to verify JAMB profile.'
        );
    }

    return $data;
}

/**
 * Purchase an education service.
 */
public function educationPurchase(
    string $serviceId,
    string $billersCode,
    string $variationCode,
    float $amount,
    string $phone,
    string $requestId
): array {

    $allowedServices = [
        'jamb',
        'waec',
        'waec-registration',
    ];

    if (!in_array($serviceId, $allowedServices, true)) {
        throw new RuntimeException(
            'Invalid education service.'
        );
    }

    $payload = [
        'request_id' => $requestId,

        'serviceID' => $serviceId,

        'billersCode' => $billersCode,

        'variation_code' => $variationCode,

        'amount' => $amount,

        'phone' => $phone,
    ];

    $response = $this->postRequest()
        ->post(
            $this->baseUrl . '/pay',
            $payload
        );

    if (!$response->successful()) {
        throw new RuntimeException(
            'VTpass education purchase request failed: '
            . $response->body()
        );
    }

    return $response->json();
}


    /*
    |--------------------------------------------------------------------------
    | REQUERY
    |--------------------------------------------------------------------------
    */

    /**
     * Requery a VTpass transaction.
     */
    public function requery(string $requestId): array
    {
        $response = $this->postRequest()
            ->post(
                $this->baseUrl . '/requery',
                [
                    'request_id' => $requestId,
                ]
            );

        if (!$response->successful()) {
            throw new RuntimeException(
                'Unable to query VTpass transaction.'
            );
        }

        return $response->json();
    }
}
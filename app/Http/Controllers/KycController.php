<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KycController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'nin' => 'required|digits:11',
        ]);

        $user = auth()->user();

        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PREMBLY_API_KEY'),
                'x-api-key'      => env('PREMBLY_APP_ID'),
                'Accept'         => 'application/json',
            ])->post('https://api.prembly.com/identitypass/verification/nin', [
                'number' => $request->nin,
            ]);

            // Log the full response
            Log::info('Prembly Response', [
                'status' => $response->status(),
                'body'   => $response->json(),
            ]);

            if (!$response->successful()) {

                return back()->withErrors([
                    'nin' => 'Verification server returned an error.',
                ]);
            }

            $data = $response->json();

            /**
             * CHANGE THIS CONDITION
             * according to your actual Prembly response.
             */
            if (isset($data['status']) && $data['status'] == true) {

                $user->update([
                    'nin' => $request->nin,
                    'kyc_verified' => true,
                    'kyc_verified_at' => now(),
                ]);

                return back()->with('success', 'NIN verified successfully.');
            }

            return back()->withErrors([
                'nin' => $data['message'] ?? 'NIN verification failed.',
            ]);

        } catch (\Exception $e) {

            Log::error('Prembly Error', [
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'nin' => 'Unable to connect to Prembly.',
            ]);
        }
    }
}
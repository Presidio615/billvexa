<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],



    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],




    'vtpass' => [
        'base_url' => env('VTPASS_BASE_URL', 'https://sandbox.vtpass.com/api'),
        'api_key' => env('VTPASS_API_KEY'),
        'public_key' => env('VTPASS_PUBLIC_KEY'),
        'secret_key' => env('VTPASS_SECRET_KEY'),
    ],

'termii' => [
    'key' => env('tlv_81pbpElcIkLnmNvfU4cbMOmjLeXjiynPyxLHlUv06Nk'),
],

'termii' => [
    'key' => env('TERMII_API_KEY','tlv_FmqD2iFBelSvqFt_02fBCOvJHQRmE0MDlJphgspa4dA'),
    'base_url' => env('TERMII_BASE_URL', 'https://api.ng.termii.com'),
],


'paystack' => [
    'secret' => env('PAYSTACK_SECRET_KEY'),
    'public' => env('PAYSTACK_PUBLIC_KEY'),
],

'flutterwave' => [
    'public' => env('FLW_PUBLIC_KEY'),
    'secret' => env('FLW_SECRET_KEY'),
    'encryption_key' => env('FLW_ENCRYPTION_KEY'),
],


];

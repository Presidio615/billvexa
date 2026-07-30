<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VTpassService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.vtpass.url');
    }

    public function verify()
    {
        return Http::withBasicAuth(

            config('services.vtpass.username'),

            config('services.vtpass.password')

        )->get($this->baseUrl.'/service-categories');
    }
}
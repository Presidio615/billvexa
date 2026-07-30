<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = [
        'name',
        'provider',
        'charge',
        'profit',
        'minimum',
        'maximum',
        'status',
    
        'api_name',
        'api_provider',
        'api_endpoint',
        'service_code',
        'api_key',
        'api_secret',
        'sandbox',
    ];
}

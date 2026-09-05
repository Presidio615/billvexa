<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ElectricityTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'provider',
        'service_id',
        'meter_number',
        'meter_type',
        'customer_name',
        'customer_address',
        'amount',
        'discount',
        'total',
        'phone',
        'token',
        'units',
        'vtpass_transaction_id',
        'status',
        'response_message',
        'api_response',
        'purchased_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'api_response' => 'array',
        'purchased_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CableTvTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'provider',
        'service_id',
        'variation_code',
        'variation_name',
        'smart_card',
        'customer_name',
        'amount',
        'vtpass_transaction_id',
        'status',
        'response_message',
        'api_response',
        'purchased_at',
    ];

    protected $casts = [
        'api_response' => 'array',
        'amount' => 'decimal:2',
        'purchased_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

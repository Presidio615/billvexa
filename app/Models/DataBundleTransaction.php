<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataBundleTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'network',
        'service_id',
        'variation_code',
        'variation_name',
        'phone',
        'amount',
        'vtpass_transaction_id',
        'status',
        'response_message',
        'api_response',
        'purchased_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'api_response' => 'array',
        'purchased_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

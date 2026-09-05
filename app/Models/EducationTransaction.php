<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'request_id',
        'service_id',
        'variation_code',
        'service_name',
        'billers_code',
        'phone',
        'amount',
        'status',
        'vtpass_transaction_id',
        'purchased_code',
        'response',
    ];

    protected $casts = [
        'response' => 'array',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
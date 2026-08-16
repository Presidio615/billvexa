<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'contact_information',
        'currency',
        'timezone',

        // Security
        'two_factor',
        'maintenance_mode',
        'login_attempts',
        'lockout_duration',
        'session_timeout',

        // Wallet
        'minimum_deposit',
        'minimum_withdrawal',

        // Profit / discounts
        'discount',
        'profit_percentage',
        'airtime_discount',
        'data_discount',
        'electricity_discount',
        'cable_discount',
        'betting_discount',
        'education_discount',
        'exam_discount',

        // APIs
        'airtime_api',
        'data_api',
        'electricity_api',
        'cable_api',
        'betting_api',

        // Email
        'smtp_server',
        'sender_name',

        // SMS
        'sms_provider',
        'sms_api_key',
    ];

    protected $casts = [
        'two_factor' => 'boolean',
        'maintenance_mode' => 'boolean',
        'login_attempts' => 'integer',
        'lockout_duration' => 'integer',
        'session_timeout' => 'integer',
    ];
}
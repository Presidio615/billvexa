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

        'two_factor',
        'maintenance_mode',
        'session_timeout',

        'minimum_deposit',
        // 'minimum_withdrawal',
        'profit_percentage',
        'airtime_discount',
        'data_discount',
        'electricity_discount',
        'cable_discount',
        'betting_discount',
        'education_discount',
        'exam_discount',

        'airtime_api',
        'data_api',
        'electricity_api',
        'cable_api',
        'betting_api',

        'smtp_server',
        'sender_name',

        'sms_provider',
        'sms_api_key',
    ];

    protected $casts = [
        'two_factor' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];
}
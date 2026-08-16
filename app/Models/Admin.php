<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'profile_photo',
        'password',
        'failed_attempts',
        'locked_until',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'locked_until' => 'datetime',
        'two_factor_expires_at' => 'datetime',
    ];
}
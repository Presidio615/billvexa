<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [

    'name',
    'email',
    'phone',
    'password',
    'profile_photo',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    //
    protected $fillable = [

    'referrer_id',
    'referred_user_id',
    'bonus',
    'status',
    'approved_at',
    'cancelled_at'

];

public function referrer()
{
    return $this->belongsTo(User::class, 'referred_by');
}

public function referrals()
{
    return $this->hasMany(User::class, 'referred_by');
}
    
}

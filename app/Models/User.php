<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Database\Factories\UserFactory;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'network',
        'amount',
        'status',
        'profile_photo',
        'password',
        'last_login_at',
        'wallet_balance',
        'account_number',
        'account_bank',
        'account_reference',

        'paystack_customer_code',
        'paystack_dva_id',
        'paystack_account_number',
        'paystack_account_name',
        'paystack_bank_name',

        'flutterwave_customer_id',
        'flutterwave_account_reference',
        'flutterwave_account_id',

        'referral_code',
        'referred_by',
        'google_id',
        'avatar',
        'wallet_balance',
    
        'wallet_status',

        // Two-Factor Authentication
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',

        // Authentication
        'remember_token',

        // kyc verification
        'nin',
        'nin_status',
        'kyc_verified',
        'kyc_verified_at',
        'kyc_verified_by',
        'kyc_rejection_reason',
        'nin_image',
        'selfie_image',
        'kyc_status',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    public function profile()
{
    return $this->hasOne(Profile::class);
}

public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function referrals()
{
    return $this->hasMany(User::class, 'referred_by');
}

public function referrer()
{
    return $this->belongsTo(User::class, 'referred_by');
}
public function notifications()
{
    return $this->hasMany(Notification::class);
}

public function deposits()
{
    return $this->hasMany(Deposit::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}
public function electricityTransactions()
{
    return $this->hasMany(
        \App\Models\ElectricityTransaction::class
    );
}
    
}

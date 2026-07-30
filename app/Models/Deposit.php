<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'amount',
        'method',
        'reference',
        'receipt',
        'status',
        'remark',
        'approved_by',
        'approved_at'

    ];

    protected $casts = [

        'approved_at' => 'datetime',
        'amount' => 'decimal:2'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'approved_by');
    }
}
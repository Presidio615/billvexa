<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $table = 'admin_notifications';

    protected $fillable = [
        'admin_id',
        'title',
        'message',
        'link',
        'is_read',
        'created_at',
        'recipient_type',
        'recipient',
        'push',
        'email',
        'sms',
        'status',
        'created_by'
    ];

    protected $casts = [
        'push' => 'boolean',
        'email' => 'boolean',
        'sms' => 'boolean',
        'is_read' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Admin Relationship
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Recipient User Relationship
    |--------------------------------------------------------------------------
    */

    public function recipientUser()
    {
        return $this->belongsTo(User::class, 'recipient', 'id');
    }
}
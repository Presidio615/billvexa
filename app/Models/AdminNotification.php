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
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
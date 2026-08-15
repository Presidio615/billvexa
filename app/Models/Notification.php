<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'icon_class',
        'link',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

}

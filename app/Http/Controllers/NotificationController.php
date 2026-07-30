<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function read(Notification $notification)
    {
        if ($notification->user_id == auth()->id()) {
            $notification->update([
                'is_read' => true,
            ]);
        }
    
        return redirect()->route('history');
    }
}
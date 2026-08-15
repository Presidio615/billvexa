<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notification history.
     */
    public function index(Request $request)
{
    $user = Auth::user();

    $query = Notification::where('user_id', $user->id);

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    // Read / Unread
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where(
            'is_read',
            $request->status === 'read'
        );
    }

    // Notification type
    if ($request->filled('type') && $request->type !== 'all') {
        $query->where('type', $request->type);
    }

    // PAGINATION
    $notifications = $query
        ->latest()
        ->paginate(5)
        ->withQueryString();

    // Total unread notifications
    $unreadCount = Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->count();

    return view('Billvexa.dashboard.notification', compact(
        'notifications',
        'unreadCount'
    ));
}


/**
 * Open a notification, mark it as read,
 * then redirect to its destination.
 */
public function read($id)
{
    $notification = Notification::where('user_id', Auth::id())
        ->findOrFail($id);

    // Mark notification as read
    $notification->update([
        'is_read' => true,
    ]);

    // Redirect to the notification's destination
    if (!empty($notification->link)) {
        return redirect($notification->link);
    }

    // Fallback if no link exists
    return redirect()->route('notifications.index');
}

    /**
     * Mark one notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->update([
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
            'unread_count' => $this->unreadCount(),
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
            'unread_count' => 0,
        ]);
    }

    /**
     * Delete one notification.
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted.',
            'unread_count' => $this->unreadCount(),
        ]);
    }

    /**
     * Delete all read notifications.
     */
    public function clearRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', true)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Read notifications cleared.',
            'unread_count' => $this->unreadCount(),
        ]);
    }

    /**
     * Get unread count.
     */
    public function count()
    {
        return response()->json([
            'unread_count' => $this->unreadCount(),
        ]);
    }

    private function unreadCount()
    {
        return Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }
}
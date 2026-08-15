<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserNotification;
use App\Mail\UserNotificationMail;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::with('recipientUser')
            ->latest()
            ->paginate(10);

        $users = User::orderBy('name')->get();

        return view('admin.notification', [
            'notifications' => $notifications,
            'users' => $users
        ]);
    }

    public function readAll()
    {
        AdminNotification::where('is_read', false)
            ->update([
                'is_read' => true,
            ]);
    
        return redirect()->route('admin.notification');
    }

    private function getNotificationIcon($type)
    {
        return match ($type) {

            'payment' =>
            'bi bi-check-circle-fill',

            'wallet' =>
            'bi bi-wallet2',

            'refund' =>
            'bi bi-arrow-counterclockwise',

            'retrieve' =>
            'bi bi-arrow-repeat',

            'approved' =>
            'bi bi-check-circle-fill',

            'security' =>
            'bi bi-shield-exclamation',

            'system' =>
            'bi bi-info-circle-fill',

            default =>
            'bi bi-bell',
        };
    }


    private function getNotificationIconClass($type)
    {
        return match ($type) {

            'payment' =>
            'icon-success',

            'wallet' =>
            'icon-primary',

            'refund' =>
            'icon-warning',

            'retrieve' =>
            'icon-info',

            'approved' =>
            'icon-success',

            'security' =>
            'icon-warning',

            'system' =>
            'icon-info',

            default =>
            'icon-primary',
        };
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:everyone,user,role',
            'recipient' => 'nullable',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:payment,wallet,refund,retrieve,approved,security,system',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find Recipients
        |--------------------------------------------------------------------------
        */

        if ($request->recipient_type === 'everyone') {

            $users = User::all();

        } elseif ($request->recipient_type === 'user') {

            $users = User::where('id', $request->recipient)->get();

        } elseif ($request->recipient_type === 'role') {

            $users = User::where('role', $request->recipient)->get();

        } else {

            $users = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | Create Admin Notification History
        |--------------------------------------------------------------------------
        */

        $notification = AdminNotification::create([

            'title' => $request->title,

            'message' => $request->message,

            'recipient_type' => $request->recipient_type,

            'recipient' => $request->recipient,

            'type' => $request->type,

            'push' => $request->has('push'),

            'email' => $request->has('email'),

            'sms' => $request->has('sms'),

            'status' => 'Pending',

            'created_by' => Auth::guard('admin')->id(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Send To Users
        |--------------------------------------------------------------------------
        */

        foreach ($users as $user) {

            /*
            |--------------------------------------------------------------------------
            | IN-APP NOTIFICATION
            |--------------------------------------------------------------------------
            */

            if ($request->has('push')) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'message' => $request->message,
                    'type' => $request->type,
                    'icon' => $this->getNotificationIcon($request->type),
                    'icon_class' => $this->getNotificationIconClass($request->type),
                    'link' => route('history'),
                    'is_read' => false,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | EMAIL
            |--------------------------------------------------------------------------
            */

            if ($request->has('email') && !empty($user->email)) {

                Mail::to($user->email)->send(
                    new UserNotificationMail(
                        $request->title,
                        $request->message
                    )
                );
            }

            /*
|--------------------------------------------------------------------------
| SMS NOTIFICATION
|--------------------------------------------------------------------------
*/

if ($request->has('sms') && !empty($user->phone)) {

    try {

        // Get Termii base URL
        $baseUrl = rtrim(
            config('services.termii.base_url'),
            '/'
        );

        // Get user's phone number
        $phone = trim($user->phone);

        /*
        |--------------------------------------------------------------------------
        | Convert Nigerian numbers to international format
        |--------------------------------------------------------------------------
        |
        | 08012345678 -> 2348012345678
        | 07012345678 -> 2347012345678
        |
        */

        if (str_starts_with($phone, '0')) {

            $phone = '234' . substr($phone, 1);

        }

        /*
        |--------------------------------------------------------------------------
        | Send SMS
        |--------------------------------------------------------------------------
        */

        $response = Http::timeout(30)
            ->acceptJson()
            ->post(
                $baseUrl . '/api/sms/send',
                [

                    'api_key' => config('services.termii.key'),

                    'to' => $phone,

                    'from' => 'BillVexa',

                    'sms' => $request->message,

                    'type' => 'plain',

                    'channel' => 'dnd',

                ]
            );


        /*
        |--------------------------------------------------------------------------
        | Log Termii Response
        |--------------------------------------------------------------------------
        */

        \Log::info('Termii SMS response', [

            'user_id' => $user->id,

            'phone' => $phone,

            'status' => $response->status(),

            'response' => $response->json(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Handle Failed Response
        |--------------------------------------------------------------------------
        */

        if ($response->failed()) {

            \Log::error('Termii SMS failed', [

                'user_id' => $user->id,

                'phone' => $phone,

                'status' => $response->status(),

                'response' => $response->body(),

            ]);

        }

    } catch (\Throwable $e) {

        \Log::error('Termii SMS exception', [

            'user_id' => $user->id,

            'phone' => $user->phone,

            'error' => $e->getMessage(),

        ]);

    }

}
            /*
            |--------------------------------------------------------------------------
            | Update History
            |--------------------------------------------------------------------------
            */

            $notification->update([
                'status' => 'Sent',
            ]);


            return back()->with(
                'success',
                'Notification sent successfully.'
            );
        }
    }
}
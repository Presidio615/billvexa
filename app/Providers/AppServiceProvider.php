<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            $setting = Setting::first();
        
            if (!$setting) {
                $setting = Setting::create([]);
            }
        
            View::share('setting', $setting);
        
            View::composer('layouts.admin', function ($view) {

        $admin = Auth::guard('admin')->user();

        if ($admin) {

            // Get latest notifications
            $notifications = AdminNotification::latest()
                ->take(10)
                ->get();

            // Count ONLY unread notifications
            $notificationCount = AdminNotification::where('is_read', false)
                ->count();

        } else {

            $notifications = collect();
            $notificationCount = 0;

        }

        $view->with([
            'admin' => $admin,
            'notifications' => $notifications,
            'notificationCount' => $notificationCount,
        ]);
    });
        config(['app.timezone' => $setting->timezone]);
        date_default_timezone_set($setting->timezone);
    }

    
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Schema;

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
        // Only load settings after the settings table exists
        if (Schema::hasTable('settings')) {

            $setting = Setting::first();

            if (!$setting) {
                $setting = Setting::create([]);
            }

            View::share('setting', $setting);

            // Set application timezone
            if (!empty($setting->timezone)) {
                config(['app.timezone' => $setting->timezone]);
                date_default_timezone_set($setting->timezone);
            }
        }

        View::composer('layouts.admin', function ($view) {

            $admin = Auth::guard('admin')->user();

            if ($admin) {

                // Get latest notifications
                $notifications = AdminNotification::latest()
                    ->take(10)
                    ->get();

                // Count only unread notifications
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
    }
}
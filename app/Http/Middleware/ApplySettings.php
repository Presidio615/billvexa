<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class ApplySettings
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::first();

        if ($setting) {

            // Apply Timezone
            if (!empty($setting->timezone)) {
                Config::set('app.timezone', $setting->timezone);
                date_default_timezone_set($setting->timezone);
            }

            // Apply Currency
            Config::set('app.currency', $setting->currency);

            // Share settings with every view
            view()->share('setting', $setting);
        }

        return $next($request);
    }
}
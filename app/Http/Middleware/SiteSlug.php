<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class SiteSlug
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $setting = Setting::first();

        $currentSlug = $setting?->site_slug ?? 'billvexa';

        if ($request->route('siteSlug') !== $currentSlug) {
            abort(404);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        
        // If no guard is specified, use the normal web/user guard
        if (empty($guards)) {
            $guards = ['web'];
        }

        // Check whether the user/admin is authenticated
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $next($request);
            }
        }
            

        // Admin routes
        if (in_array('admin', $guards)) {
            return redirect()->route('admin.login');
        }

        // Normal user routes
        return redirect()->route('signin');
    }
}
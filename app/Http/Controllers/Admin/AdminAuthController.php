<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Setting;



class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('Admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        $setting = Setting::first();
    
        $admin = Admin::where('email', $request->email)->first();
    
        // Check if account is locked
        if (
            $admin &&
            $admin->locked_until &&
            now()->lessThan($admin->locked_until)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Your account is temporarily locked until '
                        . $admin->locked_until->format('h:i A'),
                ]);
        }
    
        // Wrong password
        if (!Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
    
            if ($admin) {
    
                $admin->failed_attempts++;
    
                if ($admin->failed_attempts >= $setting->login_attempts) {
    
                    $admin->locked_until = now()->addMinutes($setting->lockout_duration);
    
                    $admin->failed_attempts = 0;
                }
    
                $admin->save();
            }
    
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ]);
        }
    
        // Successful login
        $admin = Auth::guard('admin')->user();
    
        $admin->update([
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);
    
        $request->session()->regenerate();
    
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Welcome back ' . $admin->name . '!');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
        ->route('admin.login')
        ->with('success', 'You have been logged out successfully.');
    }
}
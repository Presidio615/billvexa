<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AuditLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\Setting;
use App\Mail\AdminTwoFactorCodeMail;

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

        if (!$setting) {
            return back()
                ->withErrors([
                    'email' => 'System settings are not configured.',
                ])
                ->withInput();
        }

        $admin = Admin::where('email', $request->email)->first();

        /*
        |--------------------------------------------------------------------------
        | Check Account Lock
        |--------------------------------------------------------------------------
        */

        if (
            $admin &&
            $admin->locked_until &&
            now()->lessThan($admin->locked_until)
        ) {
            $minutes = now()->diffInMinutes(
                $admin->locked_until,
                false
            );

            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Your account is temporarily locked. '
                        . 'Please try again in '
                        . max(1, $minutes)
                        . ' minute(s).',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Attempt Login
        |--------------------------------------------------------------------------
        */

        if (
            !Auth::guard('admin')->attempt(
                $credentials,
                $request->boolean('remember')
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | Wrong Password
            |--------------------------------------------------------------------------
            */

            if ($admin) {

                $admin->failed_attempts++;

                /*
                |--------------------------------------------------------------------------
                | Lock Account After Maximum Attempts
                |--------------------------------------------------------------------------
                */

                if (
                    $admin->failed_attempts >=
                    $setting->login_attempts
                ) {

                    $admin->locked_until = now()->addMinutes(
                        $setting->lockout_duration
                    );

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

        /*
        |--------------------------------------------------------------------------
        | Successful Password Authentication
        |--------------------------------------------------------------------------
        */

        $admin = Auth::guard('admin')->user();

        $admin->update([
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Two-Factor Authentication
        |--------------------------------------------------------------------------
        */

        if ($setting->two_factor) {

            $code = (string) random_int(100000, 999999);

            $admin->update([
                'two_factor_code' => Hash::make($code),
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);

            Mail::to($admin->email)->send(
                new AdminTwoFactorCodeMail($code)
            );

            /*
            |--------------------------------------------------------------------------
            | Logout Until 2FA Is Verified
            |--------------------------------------------------------------------------
            */

            Auth::guard('admin')->logout();

            $request->session()->put(
                'admin_2fa_id',
                $admin->id
            );

            return redirect()->route('admin.2fa');
        }

        /*
        |--------------------------------------------------------------------------
        | Complete Normal Login
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        $request->session()->put(
            'admin_last_activity',
            now()->timestamp
        );

        AuditLogController::record(
            'Login',
            'Administrator logged into dashboard'
        );

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'Welcome back ' . $admin->name . '!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Two-Factor Verification
    |--------------------------------------------------------------------------
    */

    public function showTwoFactor()
    {
        if (!session()->has('admin_2fa_id')) {
            return redirect()->route('admin.login');
        }

        return view('Admin.auth.2fa');
    }


    /*
    |--------------------------------------------------------------------------
    | Verify Two-Factor Code
    |--------------------------------------------------------------------------
    */

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $adminId = session('admin_2fa_id');

        if (!$adminId) {
            return redirect()->route('admin.login');
        }

        $admin = Admin::find($adminId);

        if (!$admin) {

            session()->forget('admin_2fa_id');

            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'email' => 'Administrator account not found.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Code Exists
        |--------------------------------------------------------------------------
        */

        if (!$admin->two_factor_code) {
            return back()->withErrors([
                'code' => 'Invalid verification code.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check Code Expiration
        |--------------------------------------------------------------------------
        */

        if (
            !$admin->two_factor_expires_at ||
            now()->greaterThan(
                $admin->two_factor_expires_at
            )
        ) {
            return back()->withErrors([
                'code' => 'Your verification code has expired.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Code
        |--------------------------------------------------------------------------
        */

        if (
            !Hash::check(
                $request->code,
                $admin->two_factor_code
            )
        ) {
            return back()->withErrors([
                'code' => 'Invalid verification code.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Clear Used Code
        |--------------------------------------------------------------------------
        */

        $admin->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        session()->forget('admin_2fa_id');

        /*
        |--------------------------------------------------------------------------
        | Log Administrator In
        |--------------------------------------------------------------------------
        */

        Auth::guard('admin')->login($admin);

        $request->session()->regenerate();

        $request->session()->put(
            'admin_last_activity',
            now()->timestamp
        );

        AuditLogController::record(
            'Login',
            'Administrator logged into dashboard using two-factor authentication'
        );

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'Welcome back ' . $admin->name . '!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            AuditLogController::record(
                'Logout',
                'Administrator logged out'
            );
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}
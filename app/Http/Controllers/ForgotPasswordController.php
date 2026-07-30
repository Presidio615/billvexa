<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class ForgotPasswordController extends Controller
{


    /* =========================================================
        SHOW FORGOT PASSWORD FORM
    ========================================================= */

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }



    /* =========================================================
        SEND RESET LINK (EMAIL VALIDATION + TOKEN GENERATION)
    ========================================================= */

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);


        // 🔍 Check if user exists
        $user = User::where('email', $request->email)->first();

        // $user = User::query()->firstWhere('email', $request->email);

        if (!$user) {
            return back()->withErrors([
                'email' => 'This email does not exist.'
            ]);
        }

        // 🔐 Generate reset token
        $token = Str::random(64);

        // 💾 Store hashed token in DB

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );


        // 🔗 Create reset link
        $link = route('password.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);

        // 📩 Send email

        try {
            Mail::raw(
                "Click the link below to reset your password:\n\n{$link}",
                function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Reset Password');
                }
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Unable to send the reset email. Please try again.',
            ]);
        }
        return back()->with(
            'success',
            'Password reset link sent successfully.'
        );
    }




    /* =========================================================
        SHOW RESET PASSWORD FORM
    ========================================================= */

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }



    /* =========================================================
        RESET PASSWORD PROCESS
    ========================================================= */

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);


        // 🔍 Check token record

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

            if (!$record) {
            return back()->withErrors([
                'token' => 'Invalid or expired reset link.',
            ]);
        }

        if (!$record->created_at || now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();
        
            return back()->withErrors([
                'token' => 'This reset link has expired.',
            ]);
        }
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors([
                'token' => 'Invalid or expired reset link.'
            ]);
        }

        


        // 🔍 Check user again

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User not found.'
            ]);
        }


        // ✅ FIX: Proper password update with hashing
        $user->update([
            'password' => Hash::make($request->password),
        ]);
    

        // 🧹 Delete reset token after success

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully.');
        
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FlutterwaveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Mail\TwoFactorCodeMail;


class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|confirmed|min:8',
        ]);


        // Generate referral code
        $referralCode = strtoupper(Str::random(8));

        // Find referrer
        $referrer = User::where(
            'referral_code',
            session('referral_code')
        )->first();

        // Generate unique account number
        $accountNumber = $this->generateAccountNumber();

        // Create user

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'wallet_balance' => 0,
            'account_bank' => 'BillVexa Microfinance Bank',
            'account_number' => $accountNumber,
            'referral_code' => $referralCode,
            'referred_by' => $referrer?->id,

        ]);

        $flutterwave = app(FlutterwaveService::class);

        $accountResult = $flutterwave->createStaticVirtualAccount($user);

        // Give referral bonus
        if ($referrer) {

            // Credit ₦500
            $referrer->increment('wallet_balance', 500);

            // Save transaction
            Transaction::create([
                'user_id' => $referrer->id,
                'service' => 'Referral Bonus',
                'network' => 'N/A',
                'phone' => 'N/A',
                'amount' => 500,
                'type' => 'credit',
                'status' => 'successful',
                'reference' => 'REF-' . strtoupper(Str::random(10)),
            ]);

            // Create notification
            Notification::create([
                'user_id' => $referrer->id,
                'title' => 'New Referral',
                'message' => $user->name . ' registered using your referral link.',
                'is_read' => false,
                'link' => route('history')
            ]);
        }

        // Remove referral code from session
        session()->forget('referral_code');

        // Login new user
        Auth::login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Account created successfully.');
    }
    


    /**
     * Login user
     */
    public function sign(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ])
                ->onlyInput('email');
        }
    
        $request->session()->regenerate();
    
        $user = Auth::user();
    
        // Check if 2FA is enabled
        if ($user->two_factor_enabled) {
    
            $code = random_int(100000, 999999);
    
            $user->update([
                'two_factor_code' => $code,
                'two_factor_expires_at' => now()->addMinutes(10),
            ]);
    
            try {
    
                Mail::to($user->email)
                    ->send(new TwoFactorCodeMail($code));
    
            } catch (\Exception $e) {
    
                Auth::logout();
    
                return back()->withErrors([
                    'email' => 'Unable to send verification code.',
                ]);
            }
    
            // Store user ID in session
            session()->put('2fa_user', $user->id);
            session()->save();

            Auth::logout();
            
    
            return redirect()->route('2fa.verify');
        }
    
        return redirect()
            ->route('dashboard')
            ->with('success', 'Welcome back!');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('signin')
            ->with('success', 'You have been logged out.');
    }



    /**
    * Show Two Factor Authentication form
    */
    public function showTwoFactorForm()
    {
        if (!session()->has('2fa_user')) {
            return redirect()->route('login');
        }
            
        return view('BillVexa.auth.twofactor');
    }
    /**
     * Verify Two Factor Authentication code
     */
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = User::find(session('2fa_user'));

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->two_factor_code) {
            return redirect()->route('login');
        }

        if (now()->greaterThan($user->two_factor_expires_at)) {

            return back()->withErrors([
                'code' => 'Verification code has expired.',
            ]);
        }

        if ($request->code != $user->two_factor_code) {

            return back()->withErrors([
                'code' => 'Incorrect verification code.',
            ]);
        }

        // Clear verification code
        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
        
        // Login the user
        Auth::login($user);
        
        // Regenerate the session
        $request->session()->regenerate();
        
        session()->forget('2fa_user');

        return redirect()->route('dashboard');
    }

    public function resendTwoFactor(Request $request)
    {
        // Make sure the user is still in the 2FA process
        if (!session()->has('2fa_user')) {
            return redirect()->route('login');
        }
    
        $user = User::find(session('2fa_user'));
    
        if (!$user) {
            return redirect()->route('login');
        }
    
        // Generate new code
        $code = random_int(100000, 999999);
    
        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);
    
        // Send email
        try {
            Mail::to($user->email)
                ->send(new TwoFactorCodeMail($code));
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Unable to send verification code.',
            ]);
        }
        return back()->with(
            'success',
            'A new verification code has been sent to your email.'
        );
    }

    /**
    * Generate unique 10-digit account number
    */
    private function generateAccountNumber()
    {
        do {

            $number = (string) random_int(
                1000000000,
                9999999999
            );

        } while (
            User::where('account_number', $number)->exists()
        );

        return $number;
    }

   


}


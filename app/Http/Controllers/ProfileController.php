<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the profile page.
     */
    public function edit()
    {
        return view('BillVexa.Dashboard.profile');
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('profile_photo')) {

            if (
                $user->profile_photo &&
                Storage::disk('public')->exists($user->profile_photo)
            ) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $request
                ->file('profile_photo')
                ->store('profile_photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Your new password must be different from your current password.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    /**
     * Show logged-in devices.
     */
    public function devices()
    {
        $devices = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderByDesc('last_activity')
            ->get();

        return view('BillVexa.profile.devices', compact('devices'));
    }

    /**
     * Log out all other devices.
     */
    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ]);
        }

        Auth::logoutOtherDevices($request->password);

        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', session()->getId())
            ->delete();

        return back()->with('success', 'All other devices have been logged out successfully.');
    }

    /**
     * Enable or disable Two-Factor Authentication.
     */
    public function toggleTwoFactor()
    {
        $user = Auth::user();

        $user->two_factor_enabled = !$user->two_factor_enabled;
        $user->save();

        return back()->with(
            'success',
            $user->two_factor_enabled
                ? 'Two-factor authentication enabled.'
                : 'Two-factor authentication disabled.'
        );
    }
}
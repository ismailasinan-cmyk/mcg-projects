<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->orWhere('email', $user->email)->first();

            if ($finduser) {
                // If user exists, update google_id if missing
                if (empty($finduser->google_id)) {
                    $finduser->google_id = $user->id;
                    // Mark email as verified since it's from Google
                    if (empty($finduser->email_verified_at)) {
                        $finduser->email_verified_at = now();
                    }
                    $finduser->save();
                }

                Auth::login($finduser);
                return redirect()->intended('admin/dashboard');

            } else {
                // Create new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make(Str::random(16)), // Random password
                    'email_verified_at' => now(), // Auto-verify Google users
                ]);

                Auth::login($newUser);
                return redirect()->intended('admin/dashboard');
            }

        } catch (\Exception $e) {
            return redirect('login')->with('error', 'Something went wrong with Google Login: ' . $e->getMessage());
        }
    }
}

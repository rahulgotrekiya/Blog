<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['google' => 'Google login failed. Please try again.']);
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Link google_id if not already linked
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            Auth::login($user, remember: true);
            return redirect()->intended(route('dashboard'));
        } else {
            // Create new user from Google data
            $user = User::create([
                'name'              => $googleUser->getName(),
                'username'          => $this->generateUsername($googleUser->getName()),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password'          => null,
                'role'              => 'author',
            ]);

            Auth::login($user, remember: true);
            // New user → send to onboarding to review/complete their profile
            return redirect()->route('auth.complete-profile');
        }
    }

    /**
     * Generate a unique username from the Google display name.
     */
    private function generateUsername(string $name): string
    {
        // Convert "John Doe" → "john-doe", strip non alpha_dash chars
        $base = Str::slug($name, '-');
        $username = $base;
        $count = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . '-' . $count++;
        }

        return $username;
    }
}

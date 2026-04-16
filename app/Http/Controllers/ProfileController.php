<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar only if it's a local storage file (not a Google URL)
            $oldAvatar = $request->user()->avatar;
            if ($oldAvatar && !str_starts_with($oldAvatar, 'http')) {
                Storage::disk('public')->delete($oldAvatar);
            }

            // Store new avatar in storage/app/public/avatars/
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }
        
        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     * Google-only users can delete without providing a password.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasPassword()) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        // Collect file paths BEFORE deletion (cascade removes DB rows)
        $avatarPath = ($user->avatar && !str_starts_with($user->avatar, 'http'))
            ? $user->avatar : null;
        $postImages = $user->posts->pluck('featured_image')->filter()->values();

        Auth::logout();
        $user->delete();

        // Clean up storage files after DB deletion
        if ($avatarPath) {
            Storage::disk('public')->delete($avatarPath);
        }
        foreach ($postImages as $image) {
            Storage::disk('public')->delete($image);
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

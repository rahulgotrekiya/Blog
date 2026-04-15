<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CompleteProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('auth.complete-profile', ['user' => $request->user()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'username' => [
                'required', 'string', 'max:50', 'alpha_dash',
                \Illuminate\Validation\Rule::unique('users', 'username')->ignore($request->user()->id),
            ],
            'bio'      => ['nullable', 'string', 'max:160'],
        ];

        // Password is optional on this page — but if provided must be valid
        if ($request->filled('password')) {
            $rules['password'] = ['required', Password::defaults(), 'confirmed'];
        }

        $validated = $request->validate($rules);

        $data = [
            'username' => $validated['username'],
            'bio'      => $validated['bio'] ?? null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $request->user()->update($data);

        return redirect()->route('dashboard')->with('status', 'profile-completed');
    }
}

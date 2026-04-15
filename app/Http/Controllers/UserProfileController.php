<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $posts = $user->posts()->published()->with('category')->latest('published_at')->paginate(10);

        return view('profile.show', compact('user', 'posts'));
    }
}

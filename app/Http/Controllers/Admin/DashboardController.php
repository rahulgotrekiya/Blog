<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('is_published', true)->count(),
            'total_comments' => Comment::count(),
            'total_categories' => Category::count(),
        ];

        $recentPosts = Post::with('user')->latest()->limit(5)->get();
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentUsers'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'users_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
            'total_posts' => Post::count(),
            'posts_this_week' => Post::where('created_at', '>=', now()->subWeek())->count(),
            'published_posts' => Post::where('is_published', true)->count(),
            'draft_posts' => Post::where('is_published', false)->count(),
            'total_comments' => Comment::count(),
            'total_categories' => Category::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentPosts = Post::with('user')->latest()->limit(5)->get();
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentUsers'));
    }
}

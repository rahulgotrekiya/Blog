<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $featured = Post::published()->featured()->with(['user', 'category'])->latest('published_at')->first();

        $posts = Post::published()
            ->with(['user', 'category'])
            ->withCount('likes')
            ->latest('published_at')
            ->paginate(12);

        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('is_published', true);
        }])->get();

        return view('home', compact('featured', 'posts', 'categories'));
    }
}

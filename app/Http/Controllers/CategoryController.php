<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $posts = $category->posts()
            ->published()
            ->with(['user'])
            ->withCount('likes')
            ->latest('published_at')
            ->paginate(12);

        return view('categories.show', compact('category', 'posts'));
    }
}

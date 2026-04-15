<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts()->with('category')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'sometimes|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if (!empty($validated['is_published'])) {
            $validated['published_at'] = now();
        }

        Post::create($validated);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        if (!$post->is_published && (!auth()->check() || auth()->id() !== $post->user_id)) {
            abort(404);
        }

        $post->load(['user', 'category', 'comments.user', 'likes']);
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->with('user')
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if (!empty($validated['is_published']) && !$post->published_at) {
            $validated['published_at'] = now();
        }

        if (empty($validated['is_published'])) {
            $validated['is_published'] = false;
        }

        $post->update($validated);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
}

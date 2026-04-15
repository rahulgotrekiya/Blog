<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    public function toggleFeatured(Post $post)
    {
        $post->update(['is_featured' => !$post->is_featured]);
        $status = $post->is_featured ? 'featured' : 'unfeatured';
        return back()->with('success', "Post has been {$status}.");
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();
        return back()->with('success', 'Post deleted successfully.');
    }
}

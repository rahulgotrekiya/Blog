<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        try {
            $user->likes()->create(['post_id' => $post->id]);
            $liked = true;
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            // Already liked — unlike it instead
            $user->likes()->where('post_id', $post->id)->delete();
            $liked = false;
        }

        if (request()->ajax()) {
            return response()->json([
                'liked' => $liked,
                'count' => $post->likes()->count(),
            ]);
        }

        return back();
    }
}

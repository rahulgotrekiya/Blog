<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();
        $existing = $user->likes()->where('post_id', $post->id)->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $user->likes()->create(['post_id' => $post->id]);
            $liked = true;
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

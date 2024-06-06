<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
{
    //for liking a post
    public function like(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = Like::where('user_id', Auth::id())->where('post_id', $request->post_id)->first();

        if ($like) {
            return response()->json(['message' => 'You have already liked this post'], 400);
        }

        $like = Like::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        return response()->json($like, 201);
    }

    // For Unliking post
    public function unlike(Post $post)
    {

        $like = Like::where('user_id', Auth::id())->where('post_id', $post->id)->first();

        if (!$like) {
            return response()->json(['message' => 'You have not liked this post'], 400);
        }

        $like->delete();

        return response()->json(['message' => 'Post unliked successfully'], 200);
    }


}

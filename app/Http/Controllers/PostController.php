<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Crud for Posts
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // BAGUHIN MO BOOOOOOOOOOOI - tignan moto
        // $post = new Post();
        // $post->user_id = Auth::id();
        // $post->content = $request->content;
        // $post->save();

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json($post, 201);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        // BAGUHIN MO RIN TO BOSSS - YAN BAGUHIN MO DIIN
        // $post->content = $request->content;
        // $post->save();

        $post->update([
            'content' => $request->content,
        ]);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}

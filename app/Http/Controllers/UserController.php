<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     *  this will see timeline of the specific user
     */
    public function showLoggedInUserPosts()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Eager load the user's posts with their likes count and comments
        $user->load(['posts' => function($query) {
            $query->withCount('likes')->with('comments');
        }]);

        // Format the response to include only required information
        $user->posts = $user->posts->map(function($post) {
            return [
                'id' => $post->id,
                'content' => $post->content,
                'like_count' => $post->likes_count,
                'comments' => $post->comments->map(function($comment) {
                    return [
                        'id' => $comment->id,
                        'content' => $comment->content,
                        'user_id' => $comment->user_id,
                        'post_id' => $comment->post_id,
                        'created_at' => $comment->created_at,
                        'updated_at' => $comment->updated_at,
                    ];
                })
            ];
        });

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'posts' => $user->posts
        ]);
    }



    /**
     *  this wiil be the dashboard of the Application
     */   
    public function dashboard()
    {
        // Eager load posts with their likes count and comments
        $users = User::with(['posts' => function($query) {
            $query->withCount('likes')->with('comments');
        }])->get();

        // Format the response to include only required information
        $users = $users->map(function($user) {
            $user->posts = $user->posts->map(function($post) {
                return [
                    'id' => $post->id,
                    'content' => $post->content,
                    'like_count' => $post->likes_count,
                    'comments' => $post->comments->map(function($comment) {
                        return [
                            'id' => $comment->id,
                            'content' => $comment->content,
                            'user_id' => $comment->user_id,
                            'post_id' => $comment->post_id,
                            'created_at' => $comment->created_at,
                            'updated_at' => $comment->updated_at,
                        ];
                    })
                ];
            });
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'posts' => $user->posts
            ];
        });

        return response()->json($users);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Resources\Post\PostRecource;
use App\Models\Comments;
use App\Models\Post;
use App\Models\User;
use App\Service\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            dump($post);
        }
    }

    public function create(CreateRequest  $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $data = $request->validated();

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user) {
            $post = (new \App\Service\PostService)->createPost($request);

            return PostRecource::make($post)->resolve();

        }

        $response = ['status' => 'error', 'message' => 'User not found'];
        return response()->json($response, 404);
    }

    public function comment(Request $request, $post_id)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user) {

            $comment = new Comments();
            $comment->post_id = $post_id;
            $comment->user_id = $loggedInUser->id;
            $comment->comment = $request->input('comment');

            $comment->save();

            $response = ['status' => 'success'];
            return response()->json($response, 200);
        }

        $response = ['status' => 'error', 'message' => 'User not found'];
        return response()->json($response, 404);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            dump($post);
        }
    }

    public function create(Request $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $validated = $request->validate([
            'text' => 'required|max:255|min:10',
            'images' => 'required',
            'imageName' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user) {
            $images = [];

            foreach ($request->file('images') as $image) {

                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/images'), $imageName);

                $images[] = $imageName;
            }

            $post = new Post();
            $post->user_id = $loggedInUser->id;
            $post->text = $request->input('text');
            $post->datePublish = date('d.m.Y');
            $post->images = json_encode($images);

            $post->save();

            $response = ['status' => 'success', 'username' => $user->username, 'post' => $post->text, 'images' => $images];
            return response()->json($response, 200);

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

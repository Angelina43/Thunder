<?php

namespace App\Service;

use App\Models\Comments;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function createPost($request)
    {
        $loggedInUser = Auth::user();

        $images = [];

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {

                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('uploads/images'), $imageName);

                $images[] = $imageName;
            }
        }

        $post = new Post();
        $post->user_id = $loggedInUser->id;
        $post->text = $request->input('text');
        $post->datePublish = date('d.m.Y');
        $post->images = json_encode($images);

        $post->save();

        return $post;
    }

    public function viewPosts()
    {
        return Post::all();
    }

    public function createComment($request, $post_id){
        $loggedInUser = Auth::user();

        $comment = new Comments();
        $comment->post_id = $post_id;
        $comment->user_id = $loggedInUser->id;
        $comment->comment = $request->input('comment');

        $comment->save();

        return $comment;
    }
}

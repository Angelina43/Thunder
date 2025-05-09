<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Resources\Post\PostRecource;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index()
    {
        $post = (new \App\Service\PostService)->viewPosts();
        return  PostRecource::make($post)->resolve();
    }

    public function create(CreateRequest  $request)
    {
        $data = $request->validated();

        $post = (new \App\Service\PostService)->createPost($request);

        return PostRecource::make($post)->resolve();
    }

    public function comment(Request $request, $post_id)
    {
        $comment = (new \App\Service\PostService)->createComment($request, $post_id);

        return PostRecource::make($comment)->resolve();
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CreateRequest;
use App\Http\Resources\Post\PostRecource;
use Illuminate\Http\Request;


class PostController extends Controller
{
    public function index(): array
    {
        $post = (new \App\Service\PostService)->viewPosts();
        return  PostRecource::make($post)->resolve();
    }

    public function create(CreateRequest  $request): array
    {
        $request->validated();

        $post = (new \App\Service\PostService)->createPost($request);

        return PostRecource::make($post)->resolve();
    }

    public function comment(Request $request, $post_id): array
    {
        $comment = (new \App\Service\PostService)->createComment($request, $post_id);

        return PostRecource::make($comment)->resolve();
    }

    public function deletePost($post_id): array
    {
        $delete_post = (new \App\Service\PostService)->deletePost($post_id);

        return PostRecource::make($delete_post)->resolve();
    }

    public function deleteComment($comment_id): array
    {
        $delete_comment = (new \App\Service\PostService)->deleteComment($comment_id);

        return PostRecource::make($delete_comment)->resolve();
    }

}

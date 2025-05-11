<?php

namespace App\Service;

use App\Models\Comments;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function viewAllUsers() {

        return User::all();

    }

    public function createUser($request): array
    {
        $user = new User();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');

        $user->save();

        $data['user'] = $user;

        return $data;
    }

    public function deleteUser($user_id): array
    {
        $deleteUser = User::where('id', $user_id)->delete();

        if ($deleteUser) {
            return ['message' => 'User successfully deleted'];
        } else return ['message' => 'User is not found'];
    }

    public function deleteComment($comment_id): array
    {
        $deleteComment = Comments::where('id', $comment_id)->delete();

        if ($deleteComment) {
            return['Comment successfully deleted'];
        } else return ['message' => 'Comment not found'];
    }

    public function deletePost($post_id): array
    {
        $deletePost = Post::where('id', $post_id)->delete();

        if ($deletePost) {
            return ['message' => 'Post successfully deleted'];
        } else return ['message' => 'Post not found'];
    }
}

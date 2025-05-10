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

    public function deleteUser($request): \Illuminate\Http\JsonResponse
    {
        $deleteUser = User::where('username', $request->username)->delete();
        if ($deleteUser) {
            return response()->json(['status' => '200', 'message' => 'User successfully deleted']);
        } else return response()->json(['status' => 'error', 'message' => 'User is not found']);
    }

    public function deleteCommit($request): \Illuminate\Http\JsonResponse
    {
        $deleteComment = Comments::where('id', $request->id)->delete();

        if ($deleteComment) {
            return response()->json(['status' => '200', 'message' => 'Comment successfully deleted']);
        } else return response()->json(['status' => 'error', 'message' => 'Comment not found']);
    }

    public function deletePost($request): \Illuminate\Http\JsonResponse {
        $deletePost = Post::where('id', $request->id)->delete();

        if ($deletePost) {
            return response()->json(['status' => '200', 'message' => 'Post successfully deleted']);
        } else return response()->json(['status' => 'error', 'message' => 'Post not found']);
    }
}

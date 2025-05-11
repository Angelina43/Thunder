<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\UserRecource;
use Illuminate\Http\Request;


class AdminCotroller extends Controller
{
    public function view(): array
    {
        $users = (new \App\Service\AdminService())->viewAllUsers();

        return UserRecource::make($users)->resolve();
    }

    public function create(RegisterRequest $request): array
    {
        $request->validated();

        $register = (new \App\Service\AdminService())->createUser($request);

        return UserRecource::make($register)->resolve();
    }

    public function deleteUser($user_id): array
    {
        $delete_user = (new \App\Service\AdminService())->deleteUser($user_id);

        return UserRecource::make($delete_user)->resolve();
    }

    public function deleteComment($comment_id): array
    {

        $delete_commit = (new \App\Service\AdminService())->deleteComment($comment_id);

        return UserRecource::make($delete_commit)->resolve();

    }

    public function deletePost($post_id): array
    {

        $delete_post = (new \App\Service\AdminService())->deletePost($post_id);

        return UserRecource::make($delete_post)->resolve();

    }
}

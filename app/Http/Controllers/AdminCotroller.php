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

    public function deleteUser(Request $request): array
    {
        $delete_user = (new \App\Service\AdminService())->deleteUser($request);

        return UserRecource::make($delete_user)->resolve();
    }

    public function deleteComment(Request $request): array
    {

        $delete_commit = (new \App\Service\AdminService())->deleteCommit($request);

        return UserRecource::make($delete_commit)->resolve();

    }

    public function deletePost(Request $request): array
    {

        $delete_post = (new \App\Service\AdminService())->deletePost($request);

        return UserRecource::make($delete_post)->resolve();

    }
}

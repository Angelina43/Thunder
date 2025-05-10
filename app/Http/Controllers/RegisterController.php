<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\UserRecource;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): array
    {
        $request->validated();

        $register = (new \App\Service\RegisterService())->register($request);

        return UserRecource::make($register )->resolve();

    }

    public function login(LoginRequest $request): array
    {
        $request->validated();

        $login = (new \App\Service\RegisterService())->login($request);

        return UserRecource::make($login )->resolve();
    }

    public function logout(): array
    {
        $logout = (new \App\Service\RegisterService())->logout();

        return UserRecource::make($logout)->resolve();
    }
}

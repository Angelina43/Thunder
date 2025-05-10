<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AvatarRequest;
use App\Http\Resources\User\UserRecource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request): array
    {
        $profile = (new \App\Service\ProfileService())->profile();

        return UserRecource::make($profile)->resolve();

    }

    public function avatar(AvatarRequest $request): array
    {
        $request->validated();

        $avatar = (new \App\Service\ProfileService())->avatar($request);

        return UserRecource::make($avatar)->resolve();
    }
}



<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register($request): array
    {
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        $data['user'] = $user;

        return $data;
    }

    public function login($request): array
    {
        $user = User::where('username', $request->username)->first();

        $data['token'] = $user->createToken($request->username)->plainTextToken;
        $data['user'] = $user;

        return [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];
    }

    public function logout(): array
    {
        auth()->user()->tokens()->delete();

        return [
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ];
    }
}

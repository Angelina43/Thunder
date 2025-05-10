<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function profile(){
        $loggedInUser = Auth::user();

        return User::where('username', $loggedInUser->username)->first();
    }
    public function avatar($request)
    {
        $loggedInUser = Auth::user();

        $user = User::where('username', $loggedInUser->username)->first();

        $photo = time() . '.' . $request->photo->getClientOriginalExtension();

        $request->photo->move(public_path('uploads/images'), $photo);

        $user->photo = 'uploads/images/' . $photo;

        $user->save();

        return $user;
    }
}


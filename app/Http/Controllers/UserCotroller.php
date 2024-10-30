<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCotroller extends Controller
{
    public function index() {
        $users = User::all();

        return response()->json($users);
    }

    public function create(Request $request)
    {

        $user = new User();
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');

        $photo = time().'.'.$request->photo->getClientOriginalExtension();

        $user->photo = $request->photo->move(public_path('uploads/images'), $photo);

        $user->save();
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {

        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user) {
            $response = ['status' => 'success', 'username' => $user->username, 'photo' => $user->photo];
            return response()->json($response, 200);
        }

        //как отрабатывает админка
//        if ($user->isAdmin()){
//            $response = ['status' => 'success', 'username' => $user->username, 'role' => $user->role];
//            return response()->json($response, 200);
//        }

        $response = ['status' => 'error', 'message' => 'User not found'];
        return response()->json($response, 404);
    }

    public function avatar(Request $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user) {

            $validated = $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            if ($validated) {

                $photo = time() . '.' . $request->photo->getClientOriginalExtension();

                $user->photo = $request->photo->move(public_path('uploads/images'), $photo);

                $user->save();

                $response = ['status' => 'success'];

                return response()->json($response, 200);
            }
        }

        $response = ['status' => 'error', 'message' => 'User not found'];
        return response()->json($response, 404);
    }
}



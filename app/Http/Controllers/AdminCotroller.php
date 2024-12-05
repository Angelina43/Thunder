<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminCotroller extends Controller
{
    public function index()
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user->isAdmin()) {
            $users = User::all();
            return response()->json($users);
        } else return response()->json(['status' => 'error', 'message' => 'User is not admin']);
    }

    public function create(Request $request)
    {

        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user->isAdmin()) {
            $validated = $request->validate([
                'username' => 'required|unique:users|regex:/^[a-zA-Z ]*$/|max:255',
                'password' => 'required|min:6',
            ]);

            if ($validated) {
                $users = new User();
                $users->username = $request->input('username');
                $users->password = Hash::make($request->input('password'));
                $users->role = $request->input('role');

                $photo = time() . '.' . $request->photo->getClientOriginalExtension();

                $users->photo = $request->photo->move(public_path('uploads/images'), $photo);

                $users->save();

                return response()->json($users);
            }
        } else return response()->json(['status' => 'error', 'message' => 'User is not admin']);
    }

    public function delete(Request $request){
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user->isAdmin()) {
            $deleteUser = User::where('username', $request->username)->delete();
            return response()->json(['status' => '200', 'message' => 'User successfully deleted']);
        } else return response()->json(['status' => 'error', 'message' => 'User is not admin']);
    }
}

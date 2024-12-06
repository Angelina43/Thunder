<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Post;
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

    public function deleteUser(Request $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user->isAdmin()) {
            $deleteUser = User::where('username', $request->username)->delete();
            if($deleteUser){
                return response()->json(['status' => '200', 'message' => 'User successfully deleted']);
            } else return response()->json(['status' => 'error', 'message' => 'User is not found']);
        } else return response()->json(['status' => 'error', 'message' => 'User is not admin']);
    }

    public function deleteComment(Request $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user->isAdmin()) {
            $deleteComment = Comments::where('id', $request->id)->delete();
            if ($deleteComment) {
                return response()->json(['status' => '200', 'message' => 'Comment successfully deleted']);
            } else return response()->json(['status' => 'error', 'message' => 'Comment not found']);
        } else return response()->json(['status' => 'error', 'message' => 'User is not admin']);
    }

    public function deletePost(Request $request)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            $response = ['status' => 'error', 'message' => 'User not authenticated'];
            return response()->json($response, 401);
        }

        $user = User::where('username', $loggedInUser->username)->first();

        if ($user->isAdmin()) {
            $deletePost = Post::where('id', $request->id)->delete();
            if ($deletePost) {
                return response()->json(['status' => '200', 'message' => 'Post successfully deleted']);
            } else return response()->json(['status' => 'error', 'message' => 'Post not found']);
        } else return response()->json(['status' => 'error', 'message' => 'User is not admin']);
    }
}

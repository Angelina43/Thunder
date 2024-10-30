<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserCotroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//админка
Route::controller(UserCotroller::class)->group(function() {
    Route::post('admin/user/create', 'create');
    Route::get('admin/users/index', 'index');
});

//неавторизованный пользователь
Route::get('posts/index', [PostController::class, 'index']);

Route::controller(RegisterController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

//авторизованный пользователь
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [RegisterController::class, 'logout']);
    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('profile/avatar', [ProfileController::class, 'avatar']);
    Route::post('posts/create', [PostController::class, 'create']);
    Route::post('posts/comment/{post_id}', [PostController::class, 'comment']);
});

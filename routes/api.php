<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminCotroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//админка
Route::controller(AdminCotroller::class)->group(function() {
    Route::post('admin/users/create', 'create')->middleware('auth:sanctum'); //создание пользователя
    Route::get('admin/users/index', 'index')->middleware('auth:sanctum'); //просмотр всех пользователей
    Route::delete('admin/users/delete', 'delete')->middleware('auth:sanctum'); //удаление пользователя
});

//неавторизованный пользователь
Route::get('posts/index', [PostController::class, 'index']); //главная страница со всеми постами

Route::controller(RegisterController::class)->group(function() {
    Route::post('register', 'register'); //регистрация
    Route::post('login', 'login'); //авторизация
});

//авторизованный пользователь
Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout', [RegisterController::class, 'logout']); //выход
    Route::get('profile', [ProfileController::class, 'index']); //профиль
    Route::post('profile/avatar', [ProfileController::class, 'avatar']); //смена автара
    Route::post('posts/create', [PostController::class, 'create']); //создание поста
    Route::post('posts/comment/{post_id}', [PostController::class, 'comment']); //создание коммента
});

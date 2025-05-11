<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminCotroller;
use Illuminate\Support\Facades\Route;

Route::get('posts/index', [PostController::class, 'index']); //главная страница со всеми постами

//неавторизованный пользователь
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register'); //регистрация
    Route::post('login', 'login'); //авторизация
});

//авторизованный пользователь
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [RegisterController::class, 'logout']); //выход
    Route::get('profile', [ProfileController::class, 'index']); //профиль
    Route::post('profile/avatar', [ProfileController::class, 'avatar']); //смена автара
    Route::post('posts/create', [PostController::class, 'create']); //создание поста
    Route::post('posts/comment/create/{post_id}', [PostController::class, 'comment']); //создание коммента
    Route::delete('posts/post/delete/{post_id}', [PostController::class, 'deletePost']); //удаление своего поста
    Route::delete('posts/comment/delete/{comment_id}', [PostController::class, 'deleteComment']); //удаление своего комментария
});

//админка
Route::controller(AdminCotroller::class)->group(function () {
    Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
        Route::get('admin/users/view', 'view'); //просмотр всех пользователей
        Route::post('admin/users/create', 'create'); //создание нового пользователя
        Route::delete('admin/users/delete/{user_id}', 'deleteUser'); //удаление пользователя
        Route::delete('admin/posts/delete/{post_id}', 'deletePost'); //удаление любого поста
        Route::delete('admin/comment/delete/{comment_id}', 'deleteComment'); //удаление любого комментария
    });
});

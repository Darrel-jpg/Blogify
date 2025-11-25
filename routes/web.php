<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPostController;

// Route::get('/', function () {
//     return view('home');

// });
Route::middleware('guest')->group(function () {
    Route::get('/login-register', [AuthController::class, 'index'])->name('login-register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/blog/my-blog', [PostController::class, 'myBlog'])->name('myBlog');
    Route::get('/blog/create', [PostController::class, 'formPost'])->name('create');
    Route::post('/blog/create', [PostController::class, 'store'])->name('store');
    Route::get('/blog/{post:slug}/edit', [PostController::class, 'formPost'])->name('edit');
    Route::post('/blog/{post:id}/update', [PostController::class, 'update'])->name('update');
    Route::delete('/blog/{post:id}', [PostController::class, 'destroy'])->name('delete');
    Route::post('/blog/{post:slug}/comment', [PostController::class, 'storeComment'])->name('comment.store');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        // Manage Posts
        Route::get('/posts', [AdminPostController::class, 'posts'])->name('posts');

        // Manage Users
        Route::get('/users', [AdminUserController::class, 'users'])->name('users');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::post('/users/{user:id}/update', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user:id}', [AdminUserController::class, 'destroy'])->name('users.delete');
});

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/blog', [PostController::class, 'posts'])->name('posts');
Route::get('/blog/{post:slug}', [PostController::class, 'post'])->name('post');
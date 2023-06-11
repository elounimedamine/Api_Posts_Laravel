<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Like\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // User
    Route::get('/user', [AuthController::class, 'user'])->name('user');
    Route::put('/user-update', [AuthController::class, 'update_user'])->name('update-user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Post
    Route::get('/posts', [PostController::class, 'index'])->name('index-posts'); // all posts
    Route::post('/posts', [PostController::class, 'store'])->name('store-posts'); // create post
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('show-posts'); // get single post
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('update-posts'); // update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('destroy-posts'); // delete post

    // Comment
    Route::get('/posts/{id}/comments', [CommentController::class, 'index'])->name('index-comments'); // all comments of a post
    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('store-comments'); // create comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update'])->name('update-comments'); // update a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('destroy-comments'); // delete a comment

    // Like
    Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike'])->name('likeOrUnlike-likes'); // like or dislike back a post

});
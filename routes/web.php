<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/users',UserController::class)
->middleware(['auth', 'verified']);

Route::resource('/posts',PostController::class)
->middleware(['auth', 'verified']);

Route::get('/myprofile',[UserController::class,'myProfile'])
->middleware(['auth'])->name('myprofile');

Route::resource('/comments',CommentController::class)
->middleware(['auth', 'verified']);

Route::get('posts/comments/{postId}',[CommentController::class,'getComments'])->name('posts.comments')
->middleware(['auth', 'verified']);

Route::resource('/messages', MessageController::class)
->middleware(['auth', 'verified']);

Route::get('/getMessages/{id}',[MessageController::class,'getMessages'])
->middleware(['auth', 'verified']);

Route::get('/posts/{post}/check', [LikeController::class,'check'])->name('like.check');

Route::post('posts/{post}/likes', [LikeController::class,'store']);

Route::post('/follow/{userId}',[FollowController::class,'store']);

Route::post('/follow/{userId}/destroy',[FollowController::class,'destroy']);

Route::get('/follow/{userId}/check',[FollowController::class,'check']);

Route::get('/followingAmount/{userId}',[FollowController::class,'followingAmount']);

Route::get('/followerAmount/{userId}',[FollowController::class,'followerAmount']);

Route::get('/users/followingList/{userId}',[FollowController::class,'getfollowingList']);
Route::get('/users/followerList/{userId}',[FollowController::class,'getfollowerList']);

require __DIR__.'/auth.php';

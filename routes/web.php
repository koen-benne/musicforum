<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostsController::class, 'index'])->name('home');

Route::get('/login', [FeedController::class, 'login'])->name('login');
Route::get('/signin', [FeedController::class, 'signin'])->name('signin');

Route::post('/posts/search', [PostsController::class, 'search'])->name('search');
Route::post('/posts/{post}/visibility', [PostsController::class, 'visibility'])->name('posts.visibility');
Route::resource('posts', PostsController::class);

Route::get('/users/{user}', [UsersController::class, 'show'])->name('user');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::post('/users/{user}', [UsersController::class, 'update'])->name('users.update');

Route::post('comments/store', [CommentsController::class, 'store'])->name('comments.store');

Auth::routes();


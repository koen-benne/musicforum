<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostsController;
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

Route::get('/', [FeedController::class, 'show'])->name('home');

Route::get('/login', [FeedController::class, 'login'])->name('login');
Route::get('/signin', [FeedController::class, 'signin'])->name('signin');



Route::resource('posts', PostsController::class);

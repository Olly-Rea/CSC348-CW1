<?php

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

Route::get('/', 'HomeController@index')->name('home');

// Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
//     return view('dashboard');
// })->name('dashboard');

// Routes and controller functions to display feed elements
Route::get('/feed', 'PostController@index')->name('feed');
Route::get('/feed/posts', 'PostController@index')->name('posts');
Route::get('/feed/news', 'PostController@index')->name('news');
Route::post('/feed/fetch', 'PostController@fetch');

// Routes and controller to display a post
Route::get('/post/{post}', 'PostController@show')->name('post');
Route::post('/reply/fetch', 'CommentController@fetch');

// Route to display site users' profiles
Route::get('/profile/{user}', 'ProfileController@show');

// Routes that can only be used by Auth users
Route::middleware(['auth:sanctum'])->group(function () {
    // Routes to display and edit the Auth user profile
    Route::get('/Me', 'ProfileController@me')->name('me');
    Route::get('/Me/edit', 'ProfileController@edit')->name('me.edit');
    // Route to create new posts
    Route::get('/post/create', 'PostController@create')->name('post.create');
    // Route to allow the Auth User to like a 'likeable' item (but NOT access /like)
    Route::match(['get', 'post'], '/like', 'LikeController@like');
    // Route to allow the Auth user to comment on posts / reply to comments
    Route::match(['get', 'post'], '/comment/create', 'CommentController@create')->name('comment.create');
    Route::match(['get', 'post'], '/comment/edit', 'CommentController@edit')->name('comment.edit');
});

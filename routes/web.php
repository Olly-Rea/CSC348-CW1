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

Route::get('/', 'HomeController@show')->name('home');

// Routes that can only be used by Auth users
Route::middleware(['auth:sanctum'])->group(function () {
    // Routes to display, edit and delete the Auth user profile
    Route::get('/Me', 'ProfileController@me')->name('me');
    Route::post('/Me/update', 'ProfileController@update')->name('me.update');
    Route::post('/Me/delete', 'ProfileController@delete')->name('me.delete');

    // Routes to create and edit (and persist changes to) posts
    Route::get('/post/create', 'PostController@create')->name('post.create');
    Route::post('/post/create', 'PostController@save')->name('post.save');
    Route::get('/post/edit/{post}', 'PostController@edit')->name('post.edit');
    Route::post('/post/edit/{post}', 'PostController@update')->name('post.update');
    // Routes to add new elements to posts
    Route::get('/post/add/text', 'PostController@addTextInput')->name('post.add.text');
    Route::get('/post/add/image', 'PostController@addImageInput')->name('post.add.image');
    // Route to delete a post
    Route::post('/post/delete/{post}', 'PostController@delete')->name('post.delete');

    // Routes to get (and fetch) paginated news from an external api (user must be logged in to access news)
    Route::get('/feed/news', 'NewsController@index')->name('news');
    Route::post('/feed/news/fetch', 'NewsController@fetch');

    // Route to allow the Auth User to like a 'likeable' item (but NOT access the URI)
    Route::match(['get', 'post'], '/like', 'LikeController@like');
    // Route to allow the Auth user to comment on posts / reply to comments (but NOT access the URI)
    Route::match(['get', 'post'], '/comment/create', 'CommentController@create')->name('comment.create');
    // Method to allow a user to edit/delete their comments
    Route::match(['get', 'post'], '/comment/edit', 'CommentController@update')->name('comment.edit');
    Route::match(['get', 'post'], '/comment/delete', 'CommentController@delete')->name('comment.delete');
    // Notification routes
    Route::match(['get', 'post'], '/notify/read', 'NotifyController@notifyRead')->name('comment.edit');
    Route::match(['get', 'post'], '/notify/delete', 'NotifyController@notifyDelete')->name('comment.edit');
});

// Routes to display (and fetch) all feed elements
Route::get('/feed', 'HomeController@index')->name('feed');
Route::post('/feed/fetch', 'HomeController@fetch');

// Routes to display (and fetch) post elements
Route::get('/feed/posts', 'PostController@index')->name('posts');
Route::post('/feed/posts/fetch', 'PostController@fetch');
// Routes and controller to display a post
Route::get('/post/{post}', 'PostController@show')->name('post');
Route::post('/reply/fetch', 'CommentController@fetch');

// Route to display site users' profiles
Route::get('/profile/{user}', 'ProfileController@show');



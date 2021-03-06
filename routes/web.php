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

Auth::routes();

Route::get('/', function () {
    if(Auth::check())
    return redirect('/home');
    else 
    return view('auth/login');
});

Route::group(['middleware' => ['auth']], function(){
    Route::get('user/profile', 'UserController@edit');
    Route::patch('user', 'UserController@update');

    // POST URLS
    Route::resource('post', 'PostController');
    Route::get('user/posts', 'PostController@userPosts');
    Route::get('user/{id}/posts', 'PostController@userFriendPosts');

    // LIKE URLS
    Route::resource('like', 'LikeController');
    // cCOMMENT URLS
    Route::resource('comment', 'CommentController');
    // USERS URLS
    Route::resource('users', 'UserController');
    Route::get('user_info/{id}', 'UserController@user_info');
    Route::get('search', 'UserController@autocomplete');
    // FOLLOW URLS
    Route::resource('follow', 'FollowController');
    Route::get('user/followers', 'FollowController@index');

    Route::get('/home', 'PostController@index')->name('home');

    
});

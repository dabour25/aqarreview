<?php

use Illuminate\Support\Facades\Route;

/*
Aqar Review Routes
This file created by Eng.Ahmed Magdy at 8/7/2019 8:12PM
This file Modified and Developed by Eng.Ahmed Magdy
*/

use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\router;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ContactusController;
use App\Http\Controllers\User\AdsController;
use App\Http\Controllers\User\SearchController;

Route::get('/',get_controller(router::class,'index'));
Route::get('/home',get_controller(router::class,'index'));

Route::resource('/reg',get_controller(UsersController::class));
Route::group(['prefix' => 'log'],function(){
    Route::get('/','Auth\LoginController@showUserLoginForm');
    Route::get('/admin','Auth\LoginController@showAdminLoginForm');
    Route::post('/my-admin','Auth\LoginController@adminLogin');
    Route::post('/user',get_controller(LoginController::class,'userLogin'));
    Route::get('/out','Auth\LoginController@logout');
});

Route::get('lang/{language}',get_controller(router::class,'lang'));

Route::resource('/contact',get_controller(ContactusController::class));

Route::resource('/ads',get_controller(AdsController::class));

Route::get('/adpro/{slug}',get_controller(AdsController::class,'adpro'));
Route::post('/addpro/{slug}',get_controller(AdsController::class,'adproProcess'));

Route::get('/review/{slug}',get_controller(AdsController::class,'review'));

Route::get('/cat/{category}',get_controller(SearchController::class,'byCategory'));
Route::get('/rent/{category}',get_controller(SearchController::class,'rentCategory'));
Route::get('/sell/{category}',get_controller(SearchController::class,'sellCategory'));

Route::get('/search',get_controller(SearchController::class,'index'));
Route::get('/search/{search}/{type}/{min}/{max}','router@search');

Route::get('/profile','User\UsersController@profile');
Route::post('/change-profile','User\UsersController@changeImage');
Route::get('/profiles/{slug}','User\UsersController@globalProfile');
Route::get('/report/{slug}','User\UsersController@reportShow');
Route::post('/report/{slug}','User\UsersController@report');
Route::get('/follow/{slug}','User\UsersController@follow');
Route::get('/like-post/{slug}','User\PostsController@like');
Route::get('/dislike-post/{slug}','User\PostsController@dislike');

Route::get('/like-comment/{id}','User\PostsController@likeComment');
Route::get('/dislike-comment/{id}','User\PostsController@dislikeComment');

Route::get('/like-reply/{id}','User\PostsController@likeReply');
Route::get('/dislike-reply/{id}','User\PostsController@dislikeReply');

Route::resource('/posts','User\PostsController');
Route::post('/posts/comment/{slug}','User\PostsController@comment');
Route::post('/comments/reply/{id}','User\PostsController@reply');

Route::resource('/blogs','User\BlogsController');
Route::get('/like-blog/{slug}','User\BlogsController@like');
Route::get('/dislike-blog/{slug}','User\BlogsController@dislike');
Route::post('/blogs/comment/{slug}','User\BlogsController@comment');

Route::post('/edituser','process@edituser');
Route::get('/userads','router@userads');
Route::get('/removead/{id}','process@removead');

Route::get('/fav/{id}','process@fav');
Route::get('/favourites','router@favlist');

Route::get('/securepoint/{keyi}/{keyii}','router@securepoint');

//Admin
Route::group(['prefix' =>'admindb','middleware' => 'auth:admin'],function () {
    Route::get('/', 'Admin\adminrouter@index');
    Route::get('/messages', 'Admin\adminrouter@messages');

    Route::resource('/ads','Admin\AdsController');
    Route::get('/approve','Admin\AdsController@approve');
    Route::resource('/users','Admin\UserController');
    Route::resource('/admins','Admin\AdminsController');
    Route::resource('/posts','Admin\PostsController');
    Route::resource('/blogs','Admin\BlogsController');

    Route::get('/links', 'Admin\adminrouter@links');
    Route::post('/links', 'Admin\adminprocess@links');
    Route::post('/adsdefault', 'Admin\adminprocess@adsdefault');
});

Auth::routes();

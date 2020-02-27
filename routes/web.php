<?php

use Illuminate\Support\Facades\Route;

/*
Aqar Review Routes
This file created by Eng.Ahmed Magdy at 8/7/2019 8:12PM
This file Modified and Developed by Eng.Ahmed Magdy
*/

Route::get('/','router@index');
Route::get('/home','router@index');

Route::resource('/reg','User\UsersController');
Route::get('/log','Auth\LoginController@showUserLoginForm');
Route::get('/log/admin','Auth\LoginController@showAdminLoginForm');
Route::post('/login/my-admin','Auth\LoginController@adminLogin');
Route::post('/login/user','Auth\LoginController@userLogin');
Route::get('/out','Auth\LoginController@logout');

Route::get('lang/{language}','router@lang');

Route::get('/contact','router@contact');
Route::post('/sendmes','process@sendmes');

Route::resource('/ads','User\AdsController');

Route::get('/adpro/{adid}','router@adpro');
Route::post('/addpro/{adid}','process@adpro');

Route::get('/review/{adid}','router@review');

Route::get('/ad/{id}','router@ad');
Route::get('/cat/{cat}','router@cat');
Route::get('/rent/{cat}','router@rcat');
Route::get('/sell/{cat}','router@scat');

Route::get('/search','router@gsearch');
Route::get('/search/{search}/{type}/{min}/{max}','router@search');

Route::get('/profile','User\UsersController@profile');
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
    Route::resource('/users','Admin\UserController');

    Route::get('/links', 'Admin\adminrouter@links');
    Route::post('/links', 'Admin\adminprocess@links');
    Route::post('/adsdefault', 'Admin\adminprocess@adsdefault');
});

Auth::routes();
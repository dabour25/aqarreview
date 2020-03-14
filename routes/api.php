<?php

Route::get('/','API\router@index');
Route::resource('/posts','API\User\PostsController');

Route::post('/fast-upload','API\process@fastUpload');

Route::get('/like-comment','API\User\PostsController@likeComment');
Route::get('/dislike-comment','API\User\PostsController@dislikeComment');

Auth::routes();

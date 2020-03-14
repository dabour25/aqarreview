<?php

Route::get('/','API\router@index');
Route::resource('/posts','API\User\PostsController');

Route::post('/fast-upload','API\process@fastUpload');

Route::get('/like-comment','API\User\PostsController@likeComment');
Route::get('/dislike-comment','API\User\PostsController@dislikeComment');
Route::post('/comment-blog','API\User\PostsController@commentBlog');

Route::get('/like-reply','API\User\PostsController@likeReply');
Route::get('/dislike-reply','API\User\PostsController@dislikeReply');
Route::post('/reply-comment','API\User\PostsController@reply');

Auth::routes();

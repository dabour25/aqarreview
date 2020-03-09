<?php

Route::get('/','API\router@index');
Route::resource('/posts','API\User\PostsController');

Route::post('/fast-upload','API\process@fastUpload');

Auth::routes();

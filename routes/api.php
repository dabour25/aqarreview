<?php

Route::get('/','API\router@index');
Route::resource('/posts','API\User\PostsController');
Auth::routes();

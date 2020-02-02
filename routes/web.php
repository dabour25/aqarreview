<?php

/*
Aqar Review Routes
This file created by Eng.Ahmed Magdy at 8/7/2019 8:12PM
This file Modified and Developed by Eng.Ahmed Magdy
*/

Route::get('/','router@index');
Route::get('/home','router@index');

Route::get('/reg','router@reg');
Route::post('/reg','process@reg');
Route::get('/log','router@log');
Route::get('/out','Auth\LoginController@logout');

Route::get('/ar','router@ar');
Route::get('/en','router@en');

Route::get('/contact','router@contact');
Route::post('/sendmes','process@sendmes');

Route::get('/addnew','router@addnew');
Route::post('/addnew','process@addnew');

Route::get('/adpro/{adid}','router@adpro');
Route::post('/addpro/{adid}','process@adpro');

Route::get('/review/{adid}','router@review');

Route::get('/ad/{id}','router@ad');
Route::get('/cat/{cat}','router@cat');
Route::get('/rent/{cat}','router@rcat');
Route::get('/sell/{cat}','router@scat');

Route::get('/search','router@gsearch');
Route::get('/search/{search}/{type}/{min}/{max}','router@search');

Route::get('/profile','router@profile');
Route::post('/edituser','process@edituser');
Route::get('/userads','router@userads');
Route::get('/removead/{id}','process@removead');

Route::get('/fav/{id}','process@fav');
Route::get('/favourites','router@favlist');

Route::get('/securepoint/{keyi}/{keyii}','router@securepoint');

//Admin
Route::group(['prefix' =>'admindb','middleware' => 'auth'],function () {
    Route::get('/', 'adminrouter@index');
    Route::get('/messages', 'adminrouter@messages');
    Route::get('/approve', 'adminrouter@approve');
    Route::get('/review/{id}', 'adminrouter@review');
    Route::get('/approvea/{id}', 'adminprocess@approve');
    Route::get('/adscontrol', 'adminrouter@adscontrol');
    Route::get('/removead/{id}', 'adminprocess@removead');

    Route::resource('/users','Admin\UserController');

    Route::get('/links', 'adminrouter@links');
    Route::post('/links', 'adminprocess@links');
    Route::post('/adsdefault', 'adminprocess@adsdefault');
});

Auth::routes();
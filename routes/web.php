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

Route::get('/review/{adid}/{name}/{phone}','router@review');
Route::get('/review/{adid}/{name}/{phone}/{email}','router@reviewe');

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

Route::get('/admindb','adminrouter@index');
Route::get('/admindb/messages','adminrouter@messages');
Route::get('/admindb/approve','adminrouter@approve');
Route::get('/admindb/review/{id}','adminrouter@review');
Route::get('/admindb/approvea/{id}','adminprocess@approve');
Route::get('/admindb/adscontrol','adminrouter@adscontrol');
Route::get('/admindb/removead/{id}','adminprocess@removead');
Route::get('/admindb/users','adminrouter@users');
Route::get('/admindb/users/{filter}','adminrouter@usersf');
Route::post('/admindb/editusers','adminprocess@editusers');
Route::get('/admindb/links','adminrouter@links');
Route::post('/admindb/links','adminprocess@links');
Route::post('/admindb/adsdefault','adminprocess@adsdefault');

Auth::routes();
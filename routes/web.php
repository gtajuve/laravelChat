<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/chat','MessagesController');
Route::get('/chatAjax','ChatsController@index');
Route::post('/chatAjax','ChatsController@store');
Route::get('/chatAjax/{id}','ChatsController@show');
Route::put('/chatAjax/{id}','ChatsController@update');
Route::delete('/chatAjax/{id}','ChatsController@destroy');
//Route::post('/chat/{id}','MessagesController@update');
Auth::routes();

Route::get('/home', 'HomeController@index');


<?php

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


Route::resource('/subscribe', 'SubscriberController');

Route::get('/', 'OrderController@index');
Route::get('/{site}/{id}', 'OrderController@show');

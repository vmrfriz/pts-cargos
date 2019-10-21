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
Route::post('/', 'OrderController@store');//->middleware('auth');
Route::get('/create', 'OrderController@create');//->middleware('auth');
Route::get('/{db}_{id}', 'OrderController@show');
Route::put('/{db}_{id}', 'OrderController@update');//->middleware('auth');
Route::delete('/{db}_{id}', 'OrderController@destroy');//->middleware('auth');
Route::get('/edit/{db}_{id}', 'OrderController@edit');//->middleware('auth');


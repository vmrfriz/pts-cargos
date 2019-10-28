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

/**
 * SubscribeController
 */
Route::resource('/subscribe', 'SubscriberController');

/**
 * OrderController
 */
Route::get('/', 'OrderController@index');
// Create
Route::post('/', 'OrderController@store');//->middleware('auth');
Route::get('/create', 'OrderController@create');//->middleware('auth');
// Show order
Route::get('/id{id}', 'OrderController@show');
Route::get('/{db}_{id}', 'OrderController@show'); //->where(['db' => '\d+', 'id' => '[a-z0-9-]+']);
// Edit
Route::get('/id{id}/edit', 'OrderController@edit');//->middleware('auth');
Route::get('/{db}_{id}/edit', 'OrderController@edit');//->middleware('auth');
Route::put('/id{id}', 'OrderController@update');//->middleware('auth');
Route::put('/{db}_{id}', 'OrderController@update');//->middleware('auth');
// Delete
Route::delete('/id{id}', 'OrderController@destroy');//->middleware('auth');
Route::delete('/{db}_{id}', 'OrderController@destroy');//->middleware('auth');
// Reserve order
Route::post('/id{id}', 'OrderController@reserve');
Route::post('/{db}_{id}', 'OrderController@reserve');
Route::get('/reserved', 'OrderController@reserved');

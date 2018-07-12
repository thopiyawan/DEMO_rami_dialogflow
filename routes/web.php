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


Route::get('/bot', function () {
    return view('welcome');
});


Route::get('/', function (Request $request) {
    logger("message request : ", $request->all());
});
Route::post('/', ['as' => 'line.bot.message', 'uses' => 'GetMessageController@getmessage']);
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
URL::forceScheme('https');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');
Route::post('/home','HomeController@index')->middleware('auth');


Route::get('/api/v1/alltrips', 'ApiController@alltrips');
Route::get('/api/v1/tripinfo', 'ApiController@tripinfo');
Route::get('/api/v1/addtrip', 'ApiController@addtrip');


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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Route::post('/login',               'HomeController@login');
Route::post('/registration',        'HomeController@registration');
Route::post('/logout',              'HomeController@logout');

Route::get('/home',                 'HomeController@index')->name('home');

/**
 * Templates
 */
Route::get('/templates',            'TemplateController@index');
Route::get('/template/{id}',        'TemplateController@get');
Route::get('/template/delete/{id}', 'TemplateController@delete');
Route::post('/template/create',     'TemplateController@create');
Route::post('/template/update/{id}','TemplateController@update');

/**
 * Channels
 */
Route::get('/channels',             'ChannelController@index');
Route::get('/channel/{id}',         'ChannelController@get');
Route::get('/channel/delete/{id}',  'ChannelController@delete');
Route::post('/channel/create',      'ChannelController@create');
Route::post('/channel/update/{id}', 'ChannelController@update');
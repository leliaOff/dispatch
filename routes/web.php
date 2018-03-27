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

Route::post('/login',               'HomeController@login');
Route::post('/registration',        'HomeController@registration');
Route::post('/logout',              'HomeController@logout')->middleware('auth');

Route::get('/home',                 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    
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

    /**
     * Send
    */
    Route::get('/sends',                'SendController@index');
    Route::get('/send/{id}',            'SendController@get');
    Route::post('/sends/create',        'SendController@create');
    
});

/**
 * API
 */
Route::post('/api/login',               'HomeController@loginAPI');
Route::post('/api/logout',              'HomeController@logoutAPI');
Route::post('/api/token',               'HomeController@tokenAPI');
Route::post('/api/send',                'SendController@sendAPI');
Route::post('/api/resend',              'SendController@resendAPI');
Route::post('/api/status',              'SendsStatusController@findAPI');
Route::post('/api/statuses',            'SendsStatusController@allAPI');
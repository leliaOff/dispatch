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
    
    //http://dispatch/public/send/register/sms/+79608554569/{"username":"Alisa","sitename": "YANDEX.RU"}
    Route::get('/send/{type}/{channel}/{contact}/{data}',
                                        'SendController@send');

    //http://dispatch/public/status/66
    Route::get('/status/{id}',          'SendController@status');
    
});
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

 /**
  * Login
  * Request: email, password
  * Return: token
  */
Route::post('/api/login',               'HomeController@loginAPI');

/**
  * Logout
  * Request: token
  */
Route::post('/api/logout',              'HomeController@logoutAPI');

/**
  * Token
  * Request: token
  * Return: fail/success
  */
Route::post('/api/token',               'HomeController@tokenAPI');

/**
  * Send
  * Request: token, type, contact, channel, data(json)
  * Return: send_id
  */
Route::post('/api/send',                'SendController@sendAPI');

/**
  * Resend
  * Request: token, send_id
  * Return: send_id
  */
Route::post('/api/resend',              'SendController@resendAPI');

/**
  * Status
  * Request: token, send_id
  * Return: {
  *   "id": status_id, "send_id": send_id, "created_at": datetime, "updated_at": datetime, 
  *   "status_id": status_type_id, "status": { "id": status_type_id, "alias": status_type_alias, "title": status_type_title }
  * }
  */
Route::post('/api/status',              'SendsStatusController@findAPI');

/**
  * Statuses
  * Request: token, send_id
  * Return: [{
  *   "id": status_id, "send_id": send_id, "created_at": datetime, "updated_at": datetime, 
  *   "status_id": status_type_id, "status": { "id": status_type_id, "alias": status_type_alias, "title": status_type_title }
  * }]
  */
Route::post('/api/statuses',            'SendsStatusController@allAPI');
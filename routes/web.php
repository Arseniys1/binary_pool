<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/how_to_receive_signals', function () {
    return view('how_to_receive_signals');
});

Route::get('/ext_not_installed', function () {
    return view('ext_not_installed');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/sources_list/{search_mode?}', 'SourcesListController@get')->name('sources_list');

    Route::get('/profile/{user_id}/{mode?}', 'ProfileController@get')->name('profile');

    Route::post('/profile/{mode}', 'ProfileController@post')->name('edit_profile');

    Route::get('/ext', 'ExtensionController@get')->name('ext');

    Route::post('/ext', 'ExtensionController@post')->name('change_api_token');
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'api'], function () {
    Route::post('/getUser', 'Api\UserController@getUser');

    Route::post('/changeAccountMode', 'Api\UserController@changeAccountMode')->middleware('throttle:1,10');

    Route::post('/changeSource/{source_id?}', 'Api\UserController@changeSource');

    Route::post('/demo', 'Api\UserController@demo');

    Route::post('/access', 'Api\UserController@access');

    Route::post('/getNotify', 'Api\NotifyController@getNotify');

    Route::post('/sendNotify', 'Api\NotifyController@sendNotify');

    Route::post('/updateNotify', 'Api\NotifyController@updateNotify');

    Route::post('/getSourceStat', 'Api\NotifyController@getSourceStat');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

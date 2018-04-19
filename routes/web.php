<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/how_to_receive_signals', function () {
    return view('how_to_receive_signals');
});

Route::get('/sources_list/{search_mode?}', 'SourcesListController@get')->name('sources_list');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/profile/{user_id}/{mode?}', 'ProfileController@get')->name('profile');

    Route::post('/profile/{mode}', 'ProfileController@post')->name('edit_profile');

    Route::get('/subscribe/{user_id}', 'SubscribeController@get')->name('subscribe');

    Route::get('/subscribe/go/{user_id}', 'SubscribeController@subscribeGo')->name('subscribe_go');

    Route::get('/my_access', 'MyAccessController@get')->name('my_access');
});

Route::group(['middleware' => ['auth:api', 'api.headers'], 'prefix' => 'api'], function () {
    Route::post('/getUser', 'Api\UserController@getUser');

    Route::post('/changeAccountMode', 'Api\UserController@changeAccountMode');

    Route::post('/changeSource', 'Api\UserController@changeSource');

    Route::post('/demo', 'Api\UserController@demo');

    Route::post('/access', 'Api\UserController@access');

    Route::post('/getNotify', 'Api\NotifyController@getNotify');

    Route::post('/sendNotify', 'Api\NotifyController@sendNotify');

    Route::post('/updateNotify', 'Api\NotifyController@updateNotify');

    Route::post('/getSourceStat', 'Api\NotifyController@getSourceStat');
});

Auth::routes();


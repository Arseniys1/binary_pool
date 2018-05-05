<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/sources', 'SourcesController@get')->middleware('static.elements');

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

    Route::post('/sendMessage', 'Api\ChatController@postSendMessage');

    Route::post('/openChat', 'Api\ChatController@postOpenChat');
});

Auth::routes();


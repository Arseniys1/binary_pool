<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/how_to_receive_signals', function () {
    return view('how_to_receive_signals');
});

Route::get('/sources_list/{search_mode?}', 'SourcesListController@get')->name('sources_list');

Route::get('/about_service', function () {
    return view('about_service');
});

Route::post('/payment', 'PaymentController@post');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/profile/{user_id}/{mode?}', 'ProfileController@get')->name('profile');

    Route::post('/profile/{mode}', 'ProfileController@post')->name('edit_profile');

    Route::get('/subscribe/{user_id}', 'SubscribeController@get')->name('subscribe');

    Route::get('/my_access', 'MyAccessController@get')->name('my_access');

    Route::group(['prefix' => 'access'], function () {
        Route::get('/', 'AccessController@get')->name('access');
        Route::get('/requests', 'AccessController@get')->name('access.requests');
        Route::post('/requests/accept', 'AccessController@postRequestsAccept')->name('access.requests.accept');
        Route::post('/requests/reject', 'AccessController@postRequestsReject')->name('access.requests.reject');
        Route::get('/presets', 'AccessController@getPresets')->name('access.presets');
        Route::post('/presets/save', 'AccessController@postPresetsSave')->name('access.presets.save');
        Route::post('/presets/edit', 'AccessController@postPresetsEdit')->name('access.presets.edit');
        Route::post('/presets/delete', 'AccessController@postPresetsDelete')->name('access.presets.delete');
        Route::get('/links', 'AccessController@getLinks')->name('access.links');
        Route::post('/links/create', 'AccessController@postLinksCreate')->name('access.links.create');
        Route::post('/links/delete', 'AccessController@postLinksDelete')->name('access.links.delete');
        Route::get('/key/{key}', 'AccessController@getActivateLink')->name('access.activate.link');
        Route::get('/demo/{user_id}', 'AccessController@getDemo')->name('access.demo');
        Route::post('/demo/send', 'AccessController@postDemo')->name('access.requests.send');
    });
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


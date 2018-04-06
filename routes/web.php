<?php



Route::get('/', function () {
    return view('index');
});

Route::get('/sources_list/{search_mode?}', 'SourcesListController@get')->middleware('auth')->name('sources_list');

Route::get('/profile/{user_id}/{mode?}', 'ProfileController@get')->middleware('auth')->name('profile');

Route::post('/profile/{mode}', 'ProfileController@post')->middleware('auth')->name('edit_profile');

Route::get('/ext', 'ExtensionController@get')->middleware('auth')->name('ext');

Route::post('/ext', 'ExtensionController@post')->middleware('auth')->name('change_api_token');

Route::get('/ext_not_installed', 'ExtensionController@extNotInstalled')->middleware('auth');

Route::prefix('api/{api_token}')->group(function () {
    Route::get('/getUser', 'Api\UserController@getUser')->middleware('auth.api');

    Route::get('/changeAccountMode', 'Api\UserController@changeAccountMode')->middleware('auth.api', 'throttle:1,10');

    Route::get('/changeSource/{source_id?}', 'Api\UserController@changeSource')->middleware('auth.api');

    Route::get('/demo', 'Api\UserController@demo')->middleware('auth.api');

    Route::get('/access', 'Api\UserController@access')->middleware('auth.api');

    Route::get('/getNotify', 'Api\NotifyController@getNotify')->middleware('auth.api');

    Route::post('/sendNotify', 'Api\NotifyController@sendNotify')->middleware('auth.api');

    Route::post('/updateNotify', 'Api\NotifyController@updateNotify')->middleware('auth.api');

    Route::post('/getSourceStat', 'Api\NotifyController@getSourceStat')->middleware('auth.api');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

<?php

 Route::get('/dashboard', 'DashboardController@index');

    //notification

    Route::get('/notification/list', 'NotificationController@indexList');
    Route::get('/notifications', 'NotificationController@index');
    Route::post('/notification/read', 'NotificationController@store');
    Route::get('/notification/showList', 'NotificationController@showList');

    Route::get('/edit/list/{name}','PreacherController@create');
    Route::get('/edit/{name}','PreacherController@edit');
    Route::post('/edit/{name}','PreacherController@update');

     Route::get('/video-conference', 'VideoConferencesController@index');
     Route::get('/video-conference/{slug}', 'VideoConferencesController@show');

    //preacher
    //Route::get('/preacher', 'PreacherController@index');
    //Route::get('/add','PreacherController@store');

    //activity_log

    Route::get('/activity','ActivityLogController@index');

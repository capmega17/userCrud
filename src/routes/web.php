<?php

Route::middleware(['auth', 'check-user-wh'])->group(function(){

    /*Crear CRUD User*/
    Route::get('/user',                     'UserController@get')->middleware('level:15');
    Route::get('/user/create',              'UserController@create')->middleware('level:15');
    Route::post('/user/store',              'UserController@store')->middleware('level:15');
    Route::get('/user/{id}/details',        'UserController@details')->middleware('level:15');
    Route::post('/user/{id}/saveDetails',   'UserController@saveDetails')->middleware('level:15');
    Route::post('/user/{id}/delete',        'UserController@delete')->middleware('level:15');
    Route::get('/user/export/csv',          'UserController@exportToCSV')->middleware('level:15');
});
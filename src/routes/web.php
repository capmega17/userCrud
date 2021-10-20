<?php
	
Route::group(['namespace' => 'Capmega\UserCrud\Controllers', 'middleware' => ['web']], function(){
    
    /*Crear CRUD User*/
	Route::get('/user',                     'UserController@get');
	Route::get('/user/create',              'UserController@create');
	Route::post('/user/store',              'UserController@store');
	Route::get('/user/{id}/details',        'UserController@details');
	Route::post('/user/{id}/saveDetails',   'UserController@saveDetails');
	Route::post('/user/{id}/delete',        'UserController@delete');
	Route::get('/user/export/csv',          'UserController@exportToCSV');

});
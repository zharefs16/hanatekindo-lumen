<?php

// $router->group(['middleware' => 'auth.basic'], function () use ($router) {
//     $router->get('/protected', function () {
//         return 'This route is protected by Basic Authentication';
//     });
// });


Route::group(['namespace' => 'Bryanjack\Umsapi\Controllers', 'prefix' => '/ums/v1', 'as' => 'umsapi.', 'middleware' => 'auth.basic'], function () {
	Route::post('/', 'UmsapiController@index');
	Route::post('/login', 'UmsapiController@login');
	Route::post('/logout', 'UmsapiController@logout');
	Route::get('/user', 'UmsapiController@user_detail');
	Route::get('/user/list', 'UmsapiController@data_user');
	Route::post('/user/create', 'UmsapiController@create');
	Route::post('/user/update', 'UmsapiController@update');
	Route::post('/user/hapus', 'UmsapiController@hapus');
	Route::post('/setting/logo', 'UmsapiController@update_logo');
	Route::post('/setting/background', 'UmsapiController@update_background');
	Route::post('/setting/menu', 'UmsapiController@update_menu');
	Route::post('/setting/theme', 'UmsapiController@update_theme');
	Route::get('/background', 'UmsapiController@background');
	Route::get('/menu', 'UmsapiController@menu');
	Route::get('/logo', 'UmsapiController@logo');
	Route::get('/theme', 'UmsapiController@theme');
	Route::get('/theme/used', 'UmsapiController@used_theme');
});

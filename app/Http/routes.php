<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// PUBLIC ROUTES

Route::group(['middleware'=>'guest'], function(){

    Route::get('/', 'LoginController@loginForm');

    Route::post('/', 'LoginController@tryLogin');

});

// USER ROUTES

Route::group(['prefix'=>'app', 'middleware'=>'user'], function(){

	// APP MODULE

    Route::get('/', 'BarController@app');
    
    Route::post('register', 'BarController@registerSale');

    // ACCOUNT MODULE
	
	Route::get('account', 'AccountController@index');
    
    Route::post('account', 'AccountController@saveProfile');

	Route::get('logout', 'LoginController@logout');

});

// MANAGER ROUTES

Route::group(['prefix'=>'app', 'middleware'=>'manager'], function(){

	// STOCK MODULE
			
    Route::get('stock', 'StockController@dashboard');

	Route::resource('stock/category', 'CategoryController', ['except' => ['create','edit']]);

	Route::resource('stock/product', 'ProductController', ['except' => ['create','edit']]);

	// CASH MODULE

	Route::get('cash/{snapshot?}', 'CashController@dashboard')->where('snapshot', '[0-9]+');;

	Route::get('cash/register-operation', 'CashController@operationForm');

	Route::post('cash/register-operation', 'CashController@registerOperation');

	Route::get('cash/new-snapshot', 'CashController@snapshotForm');

	Route::post('cash/new-snapshot', 'CashController@createSnapshot');

	Route::get('cash/history', 'CashController@showHistory');

	// STATS MODULE
	
	Route::get('stats', 'StatsController@dashboard');
	
});

// ADMIN ROUTES

Route::group(['prefix'=>'app', 'middleware'=>'administrator'], function(){

    // USERS MODULE
	
	Route::get('users', 'UsersController@getActiveUsers');

	Route::get('users/disabled', 'UsersController@getDisabledUsers');
	
	Route::get('users/register', 'UsersController@getRegisterForm');
			
	Route::post('users/register', 'UsersController@registerNewUser');
	
	Route::get('users/change-status/{id}', 'UsersController@changeAccountStatus');
	
	Route::get('users/change-role/{id}', 'UsersController@changeAccountRole');
	
	Route::get('users/delete/{id}', 'UsersController@deleteUser');

    // SETTINGS MODULE
	
	Route::get('settings', 'SettingsController@index');

});

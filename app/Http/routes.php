<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// PUBLIC ROUTES

Route::group(['middleware'=>'guest'], function(){

    Route::get('/', 'LoginController@getLoginForm');

    Route::post('/', 'LoginController@loginAttempt');

});

// USER ROUTES

Route::group(['prefix'=>'app', 'middleware'=>'user'], function(){

	// POS MODULE

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

	Route::get('cash/{snapshot?}', 'CashController@dashboard')->where('snapshot', '[0-9]+');

	Route::get('cash/register-operation', 'CashController@operationForm');

	Route::post('cash/register-operation', 'CashController@registerOperation');

	Route::get('cash/new-snapshot', 'CashController@snapshotForm');

	Route::post('cash/new-snapshot', 'CashController@createSnapshot');

	Route::get('cash/history', 'CashController@showHistory');

	// STATS MODULE
	
	Route::get('stats/{interval?}', 'StatsController@dashboard')->where('interval', '[0-9]+[hd]');
	
});

// ADMIN ROUTES

Route::group(['prefix'=>'app', 'middleware'=>'administrator'], function(){

    // USERS MODULE
	
	Route::get('users', 'UsersController@getActiveUsers');

    Route::get('users/connections/{id}', 'UsersController@showConnections');

	Route::get('users/disabled', 'UsersController@getDisabledUsers');
	
	Route::get('users/register', 'UsersController@getRegisterForm');
			
	Route::post('users/register', 'UsersController@registerNewUser');
	
	Route::get('users/change-status/{id}', 'UsersController@changeAccountStatus')->where('id', '[0-9]+');;
	
	Route::get('users/change-role/{id}', 'UsersController@changeAccountRole')->where('id', '[0-9]+');;
	
	Route::get('users/delete/{id}', 'UsersController@deleteUser')->where('id', '[0-9]+');;

    // SETTINGS MODULE
	
	Route::get('settings', 'SettingsController@index');

});

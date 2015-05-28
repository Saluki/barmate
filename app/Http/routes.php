<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// #Laravel5
// Controller's root namespace in routes.php is defined at App\Http\Controllers
// So... you don't have te write 'uses'=>'App\Http\Controllers\PublicController@home'
// but just 'uses'=>'PublicController@home'

// TODO Setup more specific route params (restrict numbers, ...)

// PUBLIC ROUTES

Route::get('/', ['before'=>'guest', 'uses'=>'PublicController@home']);

Route::get('login', ['before'=>'guest', 'uses'=>'LoginController@loginForm']);

Route::post('login', ['before'=>['guest','csrf'], 'uses'=>'LoginController@tryLogin']);

// USER ROUTES

Route::group(['before'=>'user', 'prefix'=>'app'], function(){

	// APP MODULE

    Route::get('/', 'BarController@app');
    
    Route::post('register', 'BarController@registerSale');

    // ACCOUNT MODULE
	
	Route::get('account', 'AccountController@index');
    
    Route::post('account', ['before'=>'csrf', 'uses'=>'AccountController@saveProfile']);

	Route::get('logout', 'LoginController@logout');

});

// MANAGER ROUTES

Route::group(['before'=>'manager', 'prefix'=>'app'], function(){

	// STOCK MODULE
			
    Route::get('stock', 'StockController@dashboard');

	Route::resource('stock/category', 'CategoryController', ['except' => ['create','edit']]);

	Route::resource('stock/product', 'ProductController', ['except' => ['create','edit']]);

	// CASH MODULE

	Route::get('cash', 'CashController@dashboard');

	// Since the rest API is not used for the moment...
	/*Route::get('cash/snapshot/current', 'SnapshotController@getCurrent');
	Route::get('cash/snapshot/{id}/details', 'SnapshotController@getDetails');
	Route::resource('cash/snapshot', 'SnapshotController', ['only' => ['index','store','show']]);*/

	Route::get('cash/register-operation', 'CashController@operationForm');
	Route::post('cash/register-operation', 'CashController@registerOperation');

	Route::get('cash/new-snapshot', 'CashController@snapshotForm');
	Route::post('cash/new-snapshot', 'CashController@createSnapshot');

	Route::get('cash/history', 'CashController@showHistory');

	// STATS MODULE
	
	Route::get('stats', 'StatsController@dashboard');
	
});

// ADMIN ROUTES

Route::group(['before'=>'admin', 'prefix'=>'app'], function(){
	
	Route::get('users', 'UsersController@getActiveUsers');

	Route::get('users/disabled', 'UsersController@getDisabledUsers');
	
	Route::get('users/register', 'UsersController@getRegisterForm');
			
	Route::post('users/register', 'UsersController@registerNewUser');
	
	Route::get('users/change-status/{id}', 'UsersController@changeAccountStatus');
	
	Route::get('users/change-role/{id}', 'UsersController@changeAccountRole');
	
	Route::get('users/delete/{id}', 'UsersController@deleteUser');
	
	Route::get('settings', 'SettingsController@index');

});

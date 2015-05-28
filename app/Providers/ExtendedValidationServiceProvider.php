<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Validator;

class ExtendedValidationServiceProvider extends ServiceProvider
{

	public function boot()
	{
		Validator::extend('password', 'App\Services\ExtendedValidationService@validatePassword');
		Validator::extend('name', 'App\Services\ExtendedValidationService@validateName');
	}

	public function register()
	{
		// Only used to register new services
	}

}

?>
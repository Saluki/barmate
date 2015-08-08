<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    const DEFAULT_IDENTIFIER = 1;
    const DEFAULT_ROLE = 'ADMN';

    protected $baseUrl = 'http://localhost';

	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

    public function prepareForTests()
    {
        // Set database environment to SQLite
        Config::set('database.default', 'sqlite');

        // Migrate and seed the database
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
}

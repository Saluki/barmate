<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Config;
use DateTimeZone;
use Hash;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use PDO;
use PDOException;

class InstallController extends Controller
{
    const REQUIRED_PHP_VERSION_ID = 50509;

    const CONFIG_KEY = 'temp_settings';

    public function displayWelcome()
    {
        return view('install.welcome');
    }

    public function computeRequirements()
    {
        $requirements = [   'PHP_VERSION'           => false,
                            'OPENSSL_EXTENSION'     => false,
                            'PDO_EXTENSION'         => false,
                            'MBSTRING_EXTENSION'    => false,
                            'TOKENIZER_EXTENSION'   => false,
                            'WRITE_ACCESS'          => false ];

        if( $this->getPhpVersionId() >= self::REQUIRED_PHP_VERSION_ID )
        {
            $requirements['PHP_VERSION'] = true;
        }

        if( extension_loaded('openssl') )
        {
            $requirements['OPENSSL_EXTENSION'] = true;
        }

        if( extension_loaded('PDO') )
        {
            $requirements['PDO_EXTENSION'] = true;
        }

        if( extension_loaded('mbstring') )
        {
            $requirements['MBSTRING_EXTENSION'] = true;
        }

        if( extension_loaded('tokenizer') )
        {
            $requirements['TOKENIZER_EXTENSION'] = true;
        }

        if( is_writable(storage_path()) )
        {
            $requirements['WRITE_ACCESS'] = true;
        }

        $accepted = true;
        foreach($requirements as $requirement=>$status)
        {
            if( $status==false )
            {
                $accepted = false;
                break;
            }
        }

        return view('install.requirements')->with('requirements', $requirements)
                                            ->with('accepted', $accepted);
    }

    private function getPhpVersionId()
    {
        if( !defined('PHP_VERSION_ID') )
        {
            $version = explode('.',PHP_VERSION);
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }

        return PHP_VERSION_ID;
    }

    public function displayDatabaseForm()
    {
        return view('install.database');
    }

    public function validateDatabaseConnection(Request $request)
    {
        $this->validate($request, [
            'database_host' => 'required',
            'username'      => '',
            'password'      => '',
            'database_name' => 'required'
        ]);

        if( !$this->hasDatabaseAccess($request->input('database_host'), $request->input('username'), $request->input('password'), $request->input('database_name') ) )
        {
            return redirect('install/database')->with('error', 'Barmate could not have access to your database. Please verify your settings.')
                                                ->withInput();
        }

        if( !$request->session()->has(self::CONFIG_KEY) )
        {
            $request->session()->put(self::CONFIG_KEY, []);
        }

        $configArray = $request->session()->get(self::CONFIG_KEY);

        $configArray['db_hostname'] = $request->input('database_host');
        $configArray['db_username'] = $request->input('username');
        $configArray['db_password'] = $request->input('password');
        $configArray['db_name'] = $request->input('database_name');

        $request->session()->set(self::CONFIG_KEY, $configArray);

        return redirect('install/configuration');
    }

    private function hasDatabaseAccess($hostname, $username, $password, $database)
    {
        try
        {
            (new PDO("mysql:host=$hostname;dbname=$database", $username, $password))->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);;
        }
        catch(PDOException $e)
        {
            return false;
        }

        return true;
    }

    public function displayConfigurationForm(Request $request)
    {
        return view('install.configuration')->with('applicationUrl', $request->root())
                                            ->with('encryptionKey', str_random(32))
                                            ->with('timezonesId', DateTimeZone::listIdentifiers());
    }

    public function registerConfiguration(Request $request)
    {
        $this->validate($request, [
            'application_url'   => 'required|url',
            'encryption_key'    => 'required|size:32',
            'timezone'          => 'required'
        ]);

        $configArray = $request->session()->get(self::CONFIG_KEY);

        $configArray['app_url'] = $request->input('application_url');
        $configArray['app_key'] = $request->input('encryption_key');
        $configArray['app_timezone'] = $request->input('timezone');

        $request->session()->set(self::CONFIG_KEY, $configArray);

        try
        {
            $this->createConfigFile();
        }
        catch(Exception $e)
        {
            return redirect('install/check-config');
        }

        return redirect('install/account');
    }

    public function checkEnvironmentFile(Request $request)
    {
        if( file_exists(base_path().'/.env') )
        {
            return redirect('install/account');
        }

        return view('install.error')->with('configArray', $request->session()->get(self::CONFIG_KEY));
    }

    public function displayAccountForm()
    {
        return view('install.account');
    }

    public function registerAccount(Request $request)
    {
        $this->validate($request, [
            'first_name'        => 'required|name',
            'last_name'         => 'required|name',
            'email_address'     => 'required|email|max:150',
            'password'          => 'required|password',
            'repeat_password'   => 'required|same:password'
        ]);

        $this->migrateAndSeedDatabase();
        $this->updateAdminAccount($request->input('first_name'), $request->input('last_name'), $request->input('email_address'), $request->input('password'));

        return redirect('install/finished');
    }

    private function createConfigFile()
    {
        $configArray = session(self::CONFIG_KEY);

        $configContent = 'APP_ENV=production'.PHP_EOL;
        $configContent .= 'APP_DEBUG=false'.PHP_EOL;
        $configContent .= 'APP_URL='.$configArray['app_url'].''.PHP_EOL;
        $configContent .= 'APP_KEY='.$configArray['app_key'].''.PHP_EOL;
        $configContent .= 'APP_TIMEZONE='.$configArray['app_timezone'].''.PHP_EOL;

        $configContent .= 'DB_DRIVER=mysql'.PHP_EOL;
        $configContent .= 'DB_HOST='.$configArray['db_hostname'].''.PHP_EOL;
        $configContent .= 'DB_DATABASE='.$configArray['db_name'].''.PHP_EOL;
        $configContent .= 'DB_USERNAME='.$configArray['db_username'].''.PHP_EOL;
        $configContent .= 'DB_PASSWORD='.$configArray['db_password'].''.PHP_EOL;

        $configContent .= 'MAIL_DRIVER=smtp'.PHP_EOL;
        $configContent .= 'MAIL_HOST=mailtrap.io'.PHP_EOL;
        $configContent .= 'MAIL_PORT=2525'.PHP_EOL;
        $configContent .= 'MAIL_USERNAME=null'.PHP_EOL;
        $configContent .= 'MAIL_PASSWORD=null'.PHP_EOL;

        $configContent .= 'CACHE_DRIVER=file'.PHP_EOL;
        $configContent .= 'SESSION_DRIVER=file'.PHP_EOL;
        $configContent .= 'QUEUE_DRIVER=sync'.PHP_EOL;


        if( !is_writable(base_path()) )
        {
            throw new Exception('Could not create the configuration file');
        }

        $fileHandle = fopen(base_path().'/.env', "w");
        fwrite($fileHandle, $configContent);
        fclose($fileHandle);
    }

    private function migrateAndSeedDatabase()
    {
        Artisan::call('migrate', ['--force' => true]);

        Artisan::call('db:seed', ['--force' => true]);
    }

    private function updateAdminAccount($firstname, $lastname, $email, $password)
    {
        $admin = User::firstOrFail();

        $admin->firstname = $firstname;
        $admin->lastname = $lastname;
        $admin->email = $email;
        $admin->password_hash = Hash::make($password);

        $admin->save();
    }

    public function displayFinished(Request $request)
    {
        $request->session()->forget(self::CONFIG_KEY);

        return view('install.finished');
    }
}
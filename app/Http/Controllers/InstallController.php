<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InstallController extends Controller
{
    const REQUIRED_PHP_VERSION_ID = 50509;

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
        return;
    }

    public function displayConfigurationForm()
    {
        return view('install.configuration');
    }

    public function registerConfiguration(Request $request)
    {
        return;
    }

    public function displayAccountForm()
    {
        return view('install.account');
    }

    public function registerAccount(Request $request)
    {
        return;
    }

    public function displayFinished()
    {
        return view('install.finished');
    }
}
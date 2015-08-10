<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InstallController extends Controller
{
    public function displayWelcome()
    {
        return view('install.welcome');
    }

    public function computeRequirements()
    {
        return view('install.requirements');
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

    public function displayFinished()
    {
        return view('install.finished');
    }
}
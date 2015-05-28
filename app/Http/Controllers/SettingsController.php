<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class SettingsController extends Controller {

    public function index()
    {
        return view('settings.app');
    }

}

<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class StatsController extends Controller {

    public function dashboard()
    {
        return view('stats.app');
    }

}

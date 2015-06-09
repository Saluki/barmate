<?php namespace App\Http\Controllers;

class StatsController extends Controller {

    public function __construct()
    {

    }

    public function dashboard()
    {


        return view('stats.app');
    }

}

<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PublicController extends Controller {
	
	public function home()
	{        
		return view('public.home');
	}

}

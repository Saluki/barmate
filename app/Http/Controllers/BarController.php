<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;

class BarController extends Controller {
	
	private $saleRepository;
	
	public function __construct(SalesRepository $repository)
	{
		$this->saleRepository = $repository;
	}

    public function app() 
    {
        $stock = Categories::allProducts();

        return view('app.app')->withStock( $stock );
    }
    
    public function registerSale(Request $request)
    {
    	var_dump($request->all());
    	die();
    	
    	$this->saleRepository->register(null);
    }
    
}

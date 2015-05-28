<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Repositories\RepositoryException;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use \Response;

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
        try
        {
            foreach ($request->all() as $sale)
            {
                $this->saleRepository->register($sale);
            }
        }
        catch(RepositoryException $e)
        {
            return $e->jsonResponse();
        }

        return Response::json(["status"=>1], 200);
    }
    
}

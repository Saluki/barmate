<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Repositories\CategoryRepository;
use App\Repositories\SalesRepository;
use Illuminate\Http\Request;
use Response;

class BarController extends Controller {

    private $categoryRepository;

	private $saleRepository;
	
	public function __construct(CategoryRepository $categoryRepository, SalesRepository $saleRepository)
	{
        $this->categoryRepository = $categoryRepository;
		$this->saleRepository = $saleRepository;
	}

    public function app() 
    {
        $stock = $this->categoryRepository->allWithProducts();
		
        return view('app.app')->withStock( $stock );
    }
    
    public function registerSale(Request $request)
    {
		foreach ($request->all() as $sale)
		{
			$this->saleRepository->register($sale);
		}

        return Response::json(["status"=>1], 200);
    }
    
}

<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\RepositoryException;
use \Response, \Input;

class ProductController extends Controller {

    protected $repository;

	public function __construct(ProductRepository $repository) 
	{
		$this->repository = $repository;
	}

	/**
	 * Get all products in REST format
	 * 
	 * @link	GET 	/app/stock/product/ 
	 */ 
	public function index() 
	{
		try {

			$products = $this->repository->all();
			return Response::json( $this->repository->APIFormat($products), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	/**
	 * Store a new product in the DB
	 *
	 * @link 	POST 	/app/stock/product/
	 */
	public function store()
	{
		try {
			$product = $this->repository->store( Input::all() );
			return Response::json( ['id' => $product->id], 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	/**
	 * Get a product in REST format
	 *
	 * @link 	GET 	/app/stock/product/{id}
	 */
	public function show($id)
	{
		$product = null;
		try {
			$product = $this->repository->get($id);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}

		if( $product == null )
			return Response::json(['code'=>RepositoryException::RESOURCE_NOT_FOUND,
				'message'=>'Product with ID '.$id.' not found'], 404);

		return Response::json( $this->repository->APIFormat($product), 200);
	}

	/**
	 * Update the specified product in the DB
	 *
	 * @link 	PUT 	/app/stock/product/{id}
	 */
	public function update($id)
	{
		try {

			$product = $this->repository->update($id, Input::all() );
			
			
			return Response::json( $this->repository->APIFormat($product), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	/**
	 * Remove the specified product from storage.
	 *
	 * @link 	DELETE 	/app/stock/product/{id}
	 */
	public function destroy($id)
	{
		try {

			$product = $this->repository->softDelete($id);
			return Response::json( $this->repository->APIFormat($product), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

}

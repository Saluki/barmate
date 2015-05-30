<?php namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Exceptions\RepositoryException;
use Input;
use Response;

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
		$products = $this->repository->all();
		return Response::json( $this->repository->APIFormat($products), 200);
	}

	/**
	 * Store a new product in the DB
	 *
	 * @link 	POST 	/app/stock/product/
	 */
	public function store()
	{
		$product = $this->repository->store( Input::all() );
		return Response::json( ['id' => $product->id], 200);
	}

	/**
	 * Get a product in REST format
	 *
	 * @link 	GET 	/app/stock/product/{id}
	 */
	public function show($id)
	{
		$product = $this->repository->get($id);

		if( $product == null )
			return Response::json(['code'=>RepositoryException::RESOURCE_NOT_FOUND,
				'message'=>'Product with ID '.$id.' not found'], 404);

		return Response::json($this->repository->APIFormat($product), 200);
	}

	/**
	 * Update the specified product in the DB
	 *
	 * @link 	PUT 	/app/stock/product/{id}
	 */
	public function update($id)
	{
		$product = $this->repository->update($id, Input::all() );
		return Response::json( $this->repository->APIFormat($product), 200);
	}

	/**
	 * Remove the specified product from storage.
	 *
	 * @link 	DELETE 	/app/stock/product/{id}
	 */
	public function destroy($id)
	{
		$product = $this->repository->softDelete($id);
		return Response::json( $this->repository->APIFormat($product), 200);
	}

}

<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\Products;
use DB;
use Session;
use stdClass;
use Validator;

class ProductRepository extends Repository {

    function getModelName()
    {
        return 'App\Models\Products';
    }

	public function all() {

		try {
			return $this->model->group( Session::get('groupID') )->get();
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}

	public function get($id) {
		
		$this->validateID($id);

		try {
			return $this->model->group( Session::get('groupID') )->where('product_id', $id)->first();
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}

	public function store(array $data) {

		$this->validate($data);
		$product = $this->createModel($data);

		try {
			$product->save();
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}

		$product->id = DB::getPdo()->lastInsertId();
		return $product;
	}

	public function update($id, array $data) {

		$this->validateID($id);
		$this->validate($data, false);

		try {
			$product = $this->model->group( Session::get('groupID') )->withTrashed()->find($id);
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error while fetching'.$e->getMessage(), RepositoryException::DATABASE_ERROR);
		}

		if( $product == null )
			throw new RepositoryException('Product with ID '.$id.' not found', RepositoryException::RESOURCE_NOT_FOUND);

		if( $product->trashed() )
			throw new RepositoryException('Product with ID '.$id.' has been deleted', RepositoryException::RESOURCE_DENIED);

		$this->createModel($data, $product);

		try {
			$product->save();
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error while saving', RepositoryException::DATABASE_ERROR);
		}

		return $product;
	}

	public function softDelete($id) {

		$this->validateID($id);

		try {
			$product = $this->model->group( Session::get('groupID') )->withTrashed()->find($id);
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error while fetching', RepositoryException::DATABASE_ERROR);
		}

		if( $product == null )
			throw new RepositoryException('Product with ID'.$id.' not found', RepositoryException::RESOURCE_NOT_FOUND);

		if( $product->trashed() )
			throw new RepositoryException('Product with ID '.$id.' has been deleted', RepositoryException::RESOURCE_DENIED);

		try {
			$product->delete();
		}
		catch(\Exception $e) {
			throw new RepositoryException('Database error while deleting', RepositoryException::DATABASE_ERROR);
		}

		return $product;
	}

	/**
	 * Format a Product object or an Eloquent Collection to a REST format
	 *
	 * @param  	object 	$product 	MUST be a Product object or an Eloquent Collection
	 * @return 	mixed 				In the case of a Collection, an array of REST object. 
	 *								Otherwise a REST object.
	 */
	public function APIFormat($products) {

		if( !is_object($products) )
			return null;

		// If it's simply a Product class
		if( strpos(get_class($products), 'Products') != FALSE )
			return $this->formatRecord( $products );

		$responseArray = [];
		foreach ($products as $product) {

			array_push($responseArray, $this->formatRecord( $product ));
		}

		return $responseArray;
	}

	/**
	 * Validates an array of data
	 *
	 * @param 	array 	$data 		 	Data array of the form: column_alias => value_to_validate
	 * @param 	bool 	$required 	 	Indicates if validation must follow 'required' instructions
	 * @return 	void
	 * @throws 	RepositoryException 	If the validation failed
	 */
	public function validate(array $data, $required=true) {

		$rules = Products::$validationRules;

		if( $required === false ) {

			foreach ($rules as $rule => $value) {

				$rules[$rule] = str_replace('required', '', $value);
			}
		}

		$validator = Validator::make($data, $rules);

		if( $validator->fails() ) {
			throw new RepositoryException('Validation failed', RepositoryException::VALIDATION_FAILED);
		}
	}

	/**
	 * Create or update an Eloquent model with the specified data
	 *
	 * @param  	array 	$data  	Data array with the new data
	 * @param  	object  $model  Existing Eloquent model to update. If NULL, a new model will be created
	 * @return  null|$object 	The new or updated Eloquent model
	 */
	private function createModel($data, $model=NULL) {

		if( $model == NULL )
			$model = new Products();

		$columnAlias = ['category'     => 'category_id',
						'name'         => 'product_name',
						'price'        => 'price',
						'quantity'     => 'quantity',
						'description'  => 'description' ];

		foreach ($data as $name => $value) {
			
			if( !isset( $columnAlias[$name] ) )
				continue;

			if( $value !== '' )
				$model->$columnAlias[$name] = $value;
		}

		return $model;
	}

	/**
	 * Format an Eloquent 'record' into a REST oriented object
	 *
	 * @param  	object  $product  	An Eloquent object that represents a record 
	 * @return  object 				A stdObject which contains some casted attributes
	 */
	private function formatRecord($product) {

		$productObject = new stdClass();
			
		$productObject->id       = intval($product->product_id);
		$productObject->category = intval($product->category_id);
		$productObject->price    = floatval($product->price);
		$productObject->quantity = intval($product->quantity);

		$productObject->name 		= $product->product_name;
		$productObject->description = $product->description;

		return $productObject;
	}
}
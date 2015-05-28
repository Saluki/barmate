<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use \Validator, \Input, \Session, \Response, \DB;

class CategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categoriesFromGroup = Categories::allAPI();

		return Response::json( $categoriesFromGroup, 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{		
    	$validator = Validator::make(Input::all(), [
    		'title'        => 'required|alpha|between:1,50',
    		'description'  => ''
    	]);

    	if( $validator->fails() ) {
    		return Response::json( ['code'=>1, 'error'=>'Validation failed'], 400);
    	}

		$category = new Categories();
		$category->group_id  = Session::get('groupID');
		$category->category_title = Input::get('title');
		$category->description = Input::get('description');
		$category->is_active = true;

		if( !$category->save() ) {

			return Response::json( ['code'=>2, 'error'=>'Database error'], 400);
		}

    	return Response::json( ['id' => DB::getPdo()->lastInsertId() ], 200);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if( !$this->isID($id) )
			return Response::json( ['code'=>1, 'error'=>'Parameter must be an integer'], 400);

		$category = Categories::fromGroup()->find($id);

		if( $category == null )
			return Response::json();

		return Response::json($category, 200);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator = Validator::make(Input::all(), [
    		'title'        => 'required|alpha|between:1,50',
    		'description'  => ''
    	]);

    	if( $validator->fails() ) {
    		return Response::json( ['code'=>3, 'error'=>'Validation failed'], 400);
    	}

		if( !$this->isID($id) )
			return Response::json(['code'=>1, 'error'=>'Parameter must be numeric'], 400);

		$category = Categories::fromGroup()->find($id);

		if( $category == null )
			return Response::json( ['code'=>2, 'error'=>'Category not found'] , 400);

		$category->category_title = Input::get('title');
		$category->description = Input::get('description');

		if( !$category->save() ) {

			return Response::json( ['code'=>2, 'error'=>'Database error'], 400);
		}

    	return Response::json( [], 200);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( !$this->isID($id) )
			return Response::json(['code'=>1, 'error'=>'Parameter must be numeric'], 400);

		$category = Categories::fromGroup()->find($id);
		
		if( $category == null )
			return Response::json( ['code'=>2, 'error'=>'Category not found'], 400);

		$products = Categories::find($id)->products()->get();

		if( count($products) != 0 )
			return Response::json( ['code'=>3, 'error'=>'Category not empty'], 400);

		try {
			$category->delete();
		}
		catch(\Exception $e) {
			return Response::json( ['code'=>4, 'error'=>'Database error'], 400);
		}

    	return Response::json( [], 200);
	}

	private function isID($id) {

		return (bool) preg_match('/^[0-9]{1,10}$/', $id);
	}
}

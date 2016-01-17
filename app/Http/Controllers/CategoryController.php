<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Models\Categories;
use App\Repositories\CategoryRepository;
use DB;
use Illuminate\Http\Request;
use Input;
use Response;
use Validator;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

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
	public function store(Request $request)
	{		
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|name|between:1,50',
    	]);

    	if( $validator->fails() ) {
    		return response()
                ->json(['code'=>1, 'error'=>'Validation failed'])
                ->setStatusCode(400);
    	}

        if( $this->categoryRepository->contains($request->input('title')) ) {
            return response()
                ->json(['code'=>2, 'error'=>'Category name already exists'])
                ->setStatusCode(400);
        }

        try {
            $this->categoryRepository->store($request->all());
        }
        catch(RepositoryException $e) {
            return response()
                ->json(['code'=>2, 'error'=>'Database error'])
                ->setStatusCode(400);
        }

    	return response()->json(['id' => DB::getPdo()->lastInsertId()]);
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
	public function update($id, Request $request)
	{
		$validator = Validator::make(Input::all(), [
    		'title'        => 'required|alpha|between:1,50',
    		'description'  => ''
    	]);

    	if( $validator->fails() ) {
    		return Response::json( ['code'=>3, 'error'=>'Validation failed'], 400);
    	}

		if( !$this->isID($id) ) {
            return Response::json(['code' => 1, 'error' => 'Parameter must be numeric'], 400);
        }

        if( $this->categoryRepository->contains($request->input('title')) ) {
            return response()
                ->json(['code'=>2, 'error'=>'Category name already exists'])
                ->setStatusCode(400);
        }

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

<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Input;
use Response;

class ProductController extends Controller
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all products in REST format
     *
     * @link    GET    /app/stock/product/
     */
    public function index()
    {
        $products = $this->repository->all();
        return response()->json($this->repository->APIFormat($products), 200);
    }

    /**
     * Store a new product in the DB
     *
     * @link    POST    /app/stock/product/
     */
    public function store(Request $request, CategoryRepository $categoryRepository)
    {
        $categoryRepository->get($request->input('category'));
        $product = $this->repository->store($request->all());

        return response()->json(['id' => $product->id], 200);
    }

    /**
     * Get a product in REST format
     *
     * @link    GET    /app/stock/product/{id}
     */
    public function show($id)
    {
        $product = $this->repository->get($id);

        if (is_null($product)) {
            return response()->json(['code' => RepositoryException::RESOURCE_NOT_FOUND,
                'message' => 'Product with ID ' . $id . ' not found'], 404);
        }

        return response()->json($this->repository->APIFormat($product), 200);
    }

    /**
     * Update the specified product in the DB
     *
     * @link    PUT    /app/stock/product/{id}
     */
    public function update(Request $request, $id)
    {
        $product = $this->repository->update($id, $request->all());
        return response()->json($this->repository->APIFormat($product), 200);
    }

    /**
     * Remove the specified product from storage.
     *
     * @link    DELETE    /app/stock/product/{id}
     */
    public function destroy($id)
    {
        $product = $this->repository->softDelete($id);
        return response()->json($this->repository->APIFormat($product), 200);
    }

}

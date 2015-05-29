<?php namespace App\Http\Controllers;

use App\Models\Categories;

class StockController extends Controller {

    public function dashboard()
    {
        $categories = Categories::allAPI();

        return view('stock.app')->with('categories', $categories);
    }

}

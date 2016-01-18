<?php namespace App\Http\Controllers;

use App\Models\Categories;
use App\Repositories\CategoryRepository;
use App\Repositories\SettingRepository;

class StockController extends Controller {

    private $settingRepository;
    private $categoryRepository;

    public function __construct(SettingRepository $settingRepository, CategoryRepository $categoryRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function dashboard()
    {
        $categories = $this->categoryRepository->allAPI();
        $stockEmptyAlert = intval( $this->settingRepository->getValue(SettingRepository::STOCK_EMPTY_ALERT) );

        return view('stock.app')->with('categories', $categories)
                                ->with('stockEmptyAlert', $stockEmptyAlert);
    }

}

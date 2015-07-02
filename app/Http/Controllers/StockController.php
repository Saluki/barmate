<?php namespace App\Http\Controllers;

use App\Models\Categories;
use App\Repositories\SettingRepository;

class StockController extends Controller {

    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function dashboard()
    {
        $categories = Categories::allAPI();
        $stockEmptyAlert = intval( $this->settingRepository->getValue(SettingRepository::STOCK_EMPTY_ALERT) );

        return view('stock.app')->with('categories', $categories)
                                ->with('stockEmptyAlert', $stockEmptyAlert);
    }

}

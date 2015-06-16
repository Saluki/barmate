<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserRepository;
use Exception;

class StatsController extends Controller {
    
    const DEFAULT_INTERVAL = '30d';

    protected $saleRepository;
    protected $userRepository;
    protected $productRepository;

    public function __construct(SaleRepository $saleRepository, UserRepository $userRepository, ProductRepository $productRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function dashboard($interval=self::DEFAULT_INTERVAL)
    {
        $intervalData = $this->extractIntervalData($interval);

        $sales = $this->saleRepository->countByInterval($intervalData);
        $users = $this->userRepository->all();
        $products = $this->productRepository->all();

        $title = $this->getTitleFromInterval($intervalData);

        return view('stats.app')->with('title', $title)
                                ->with('sales', $sales)
                                ->with('users', $users)
                                ->with('products', $products);
    }

    private function extractIntervalData($intervalString)
    {
        $type = substr($intervalString, -1);
        $nb = intval(substr($intervalString, 0, -1));

        if( $type=='h' )
        {
            return CarbonInterval::hours($nb);
        }
        elseif( $type=='d' )
        {
            return CarbonInterval::days($nb);
        }

        throw new Exception('Could not extract interval data from '.$intervalString);
    }

    private function getTitleFromInterval(CarbonInterval $interval)
    {
        if( $interval->h>0 )
            return 'Last '.$interval->h.' hours';

        if( $interval->d>0 )
            return 'Last '.$interval->d.' days';

        return 'Last '.$interval->forHumans();
    }

}

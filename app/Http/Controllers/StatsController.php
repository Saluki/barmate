<?php

namespace App\Http\Controllers;

use Carbon\CarbonInterval;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserRepository;
use Exception;

class StatsController extends Controller {
    
    const DEFAULT_INTERVAL = '15d';

    protected $saleRepository;
    protected $productRepository;

    public function __construct(SaleRepository $saleRepository, ProductRepository $productRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
    }

    public function dashboard($interval=self::DEFAULT_INTERVAL)
    {
        $intervalData = $this->extractIntervalData($interval);

        $sales = $this->saleRepository->countByInterval($intervalData);
        $users = $this->saleRepository->rankUsersByInterval($intervalData);
        $products = $this->productRepository->rankBySalesInInterval($intervalData);

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
            if( $nb>24 )
            {
                $nb = 24;
            }

            return CarbonInterval::hours($nb);
        }
        elseif( $type=='d' )
        {
            if( $nb>30 )
            {
                $nb = 30;
            }

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

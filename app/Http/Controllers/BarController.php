<?php namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\SaleDetailsRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SnapshotDetailsRepository;
use App\Repositories\SnapshotRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class BarController extends Controller {

    private $categoryRepository;

	private $saleRepository;

    private $saleDetailsRepository;

    private $snapshotRepository;

    private $snapshotDetailsRepository;

	public function __construct(CategoryRepository $categoryRepository, SaleRepository $saleRepository,
                                    SaleDetailsRepository $saleDetailsRepository, SnapshotRepository $snapshotRepository,
                                    SnapshotDetailsRepository $snapshotDetailsRepository)
	{
        $this->categoryRepository = $categoryRepository;
		$this->saleRepository = $saleRepository;
        $this->saleDetailsRepository = $saleDetailsRepository;
        $this->snapshotDetailsRepository = $snapshotDetailsRepository;
        $this->snapshotRepository = $snapshotRepository;
	}

    public function app() 
    {
        $stock = $this->categoryRepository->allWithProducts();
		
        return view('app.app')->withStock( $stock );
    }
    
    public function registerSale(Request $request)
    {
        DB::beginTransaction();

		foreach ($request->all() as $sale)
		{
			$saleId = $this->saleRepository->register($sale);

            foreach($sale['items'] as $item)
            {
                $item['sale'] = $saleId;
                $this->saleDetailsRepository->store($item);
            }

            $currentSnapshotId = $this->snapshotRepository->current()->cs_id;

            $this->snapshotDetailsRepository->store([   'type'        => 'SALE',
                                                        'sum'         => $sale['price'],
                                                        'timestamp'   => $sale['timestamp'],
                                                        'sale_id'     => $saleId,
                                                        'snapshot_id' => $currentSnapshotId]);
		}

        DB::commit();

        return Response::json(["status"=>1], 200);
    }
}

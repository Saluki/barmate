<?php namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleDetailsRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SnapshotDetailsRepository;
use App\Repositories\SnapshotRepository;
use Illuminate\Http\Request;
use Response;
use DB;

class BarController extends Controller
{
    private $categoryRepository;

    private $saleRepository;

    private $saleDetailsRepository;

    private $snapshotRepository;

    private $snapshotDetailsRepository;

    public function __construct(CategoryRepository $categoryRepository,
                                SaleRepository $saleRepository,
                                SaleDetailsRepository $saleDetailsRepository,
                                SnapshotRepository $snapshotRepository,
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

        return view('app.app')->with('stock', $stock);
    }

    public function registerSale(Request $request, ProductRepository $productRepository)
    {
        $currentSnapshotId = $this->snapshotRepository->current()->cs_id;

        foreach ($request->all() as $sale) {

            DB::beginTransaction();

            $formattedSaleDate = ['time' => $sale['timestamp'],
                'sum' => $sale['price'],
                'paid' => $sale['cash']];

            $saleId = $this->saleRepository->register($formattedSaleDate);

            foreach ($sale['items'] as $item) {
                $formattedSaleDetail = ['sale_id' => $saleId,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'current_price' => $item['price']];

                $this->saleDetailsRepository->store($formattedSaleDetail);

                $productRepository->decrementQuantity($item['id'], $item['quantity']);
            }

            $this->snapshotDetailsRepository->store(['type' => 'SALE',
                'sum' => min($sale['price'], $sale['cash']),
                'time' => $sale['timestamp'],
                'sale_id' => $saleId,
                'cs_id' => $currentSnapshotId]);

            DB::commit();
        }

        return Response::json(['status' => 1], 200);
    }
}

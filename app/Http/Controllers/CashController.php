<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\SnapshotRepository;
use App\Repositories\SnapshotDetailsRepository;
use App\Repositories\RepositoryException;
use \Input, \Redirect, \Validator;

class CashController extends Controller {

	public function __construct(SnapshotRepository $repository, SnapshotDetailsRepository $detailsRepository)
	{
		$this->repository = $repository;
		$this->detailsRepository = $detailsRepository;
	}

    public function dashboard()
    {
        try {

    	   $currentRepository = $this->repository->current();
    	   $snapshotDetails = $this->detailsRepository->fromSnapshot( $currentRepository->cs_id );
        }
        catch(RepositoryException $e) {

            if( $e->getCode() == RepositoryException::RESOURCE_NOT_FOUND ) {
                return view('cash.init');
            }

            App::abort(500);
        }

    	$cashArray = [ floatval($currentRepository->amount) ];
    	$lastAmount = $currentRepository->amount;

        $lastOperation = 0;
        $cashBySales = 0;

    	foreach ($snapshotDetails as $detail) {
    		
    		$lastAmount += $detail->sum;
    		array_push($cashArray, $lastAmount);

            if( $detail->type == 'CASH' ) {
                $lastOperation = $detail->sum;
            }

            if( $detail->type == 'SALE' ) {
                $cashBySales += $detail->sum;
            }
    	}

        return view('cash.app')->with('repository', $currentRepository)
        								->with('amounts', $cashArray)
                                        ->with('lastOperation', $lastOperation)
                                        ->with('cashBySales', $cashBySales);
    }

    public function operationForm()
    {
    	return view('cash.operation');
    }

    public function registerOperation()
    {
        $amount = Input::get('amount');

        // Validating and saving

        return Redirect::to('app/cash')->with('success', "Cash operation saved: add $amount&euro; in drawer");
    }

    public function snapshotForm()
    {
    	return view('cash.snapshot');
    }

    public function createSnapshot()
    {
        $title = Input::get('title');

        try {
            $this->repository->store( Input::all() );
        }
        catch(RepositoryException $e) {
            return Redirect::to('app/cash/new-snapshot')->with('error', 'Error while creating snapshot');
        }

        return Redirect::to('app/cash')->with('success', "Cash snapshot <i>$title</i> created");
    }

    public function showHistory()
    {
        try {
            $snapshots = $this->repository->history();
        }
        catch(RepositoryException $e) {
            App::abort(500);
        }

    	return view('cash.history')->with('snapshots', $snapshots);
    }
}

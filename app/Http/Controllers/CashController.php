<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Repositories\SnapshotDetailsRepository;
use App\Repositories\SnapshotRepository;
use Response;
use Input;
use Redirect;
use Validator;

class CashController extends Controller {

    private $repository;

    private $detailsRepository;

	public function __construct(SnapshotRepository $repository, SnapshotDetailsRepository $detailsRepository)
	{
		$this->repository = $repository;
		$this->detailsRepository = $detailsRepository;
	}

    public function dashboard($requestedSnapshot=null)
    {
        if( isset($requestedSnapshot) )     // Search snapshot in history
        {
            $snapshot = $this->repository->get($requestedSnapshot);
        }
        else    // Grab the current snapshot, or redirect if no one exists
        {
            try
            {
                $snapshot = $this->repository->current();
            }
            catch (RepositoryException $e)
            {
                if ($e->getCode() == RepositoryException::RESOURCE_NOT_FOUND)
                {
                    return view('cash.init');
                }

                App::abort(500);
            }
        }

        $snapshotDetails = $this->detailsRepository->fromSnapshot($snapshot->cs_id);
        $allSnapshots = $this->repository->all();

    	$cashArray = [ floatval($snapshot->amount) ];
    	$lastAmount = $snapshot->amount;

        $lastOperation = 0;
        $cashBySales = 0;
        $salesCount = 0;
        $operationsCount = 0;

    	foreach ($snapshotDetails as $detail) {
    		
    		$lastAmount += $detail->sum;
    		array_push($cashArray, $lastAmount);

            if( $detail->type == 'CASH' ) {
                $lastOperation = $detail->sum;
                $operationsCount++;
            }

            if( $detail->type == 'SALE' ) {
                $cashBySales += $detail->sum;
                $salesCount++;
            }
    	}

        return view('cash.app')->with('snapshot', $snapshot)
                                        ->with('details', $snapshotDetails)
        								->with('amounts', $cashArray)
                                        ->with('lastOperation', $lastOperation)
                                        ->with('cashBySales', $cashBySales)
                                        ->with('allSnapshots', $allSnapshots)
                                        ->with('salesCount', $salesCount)
                                        ->with('operationsCount', $operationsCount);
    }

    public function operationForm()
    {
    	return view('cash.operation');
    }

    public function registerOperation()
    {
        $amount = floatval(Input::get('amount'));
        $currentSnapshotId = $this->repository->current()->cs_id;

        $operationData = [  'type'    => 'CASH',
                            'sum'     => $amount,
                            'time'    => time(),
                            'cs_id'   => $currentSnapshotId,
                            'comment' => Input::get('comment') ];

        try {
            $this->detailsRepository->store($operationData);
        }
        catch(RepositoryException $e) {
            return Redirect::to('app/cash/register-operation')->with('error', 'Could not save operation: '.$e->getMessage())
                                                                ->withInput();
        }

        $message = ($amount<0) ? 'removed '.abs($amount).'&euro; from drawer' : 'added '.$amount.'&euro; in drawer';
        return Redirect::to('app/cash')->with('success', 'Cash operation saved: '.$message);
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
            return Redirect::to('app/cash/new-snapshot')->with('error', 'Error while creating snapshot: '.$e->getMessage())
                                                        ->withInput();
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

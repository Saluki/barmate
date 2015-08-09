<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Repositories\SnapshotDetailsRepository;
use App\Repositories\SnapshotRepository;
use Carbon\Carbon;
use Response;
use Input;
use DB;
use Redirect;
use Validator;

class CashController extends Controller
{

    private $snapshotRepository;

    private $detailsRepository;

    public function __construct(SnapshotRepository $repository, SnapshotDetailsRepository $detailsRepository)
    {
        $this->snapshotRepository = $repository;
        $this->detailsRepository = $detailsRepository;
    }

    public function dashboard($requestedSnapshot = null)
    {
        if (isset($requestedSnapshot))     // Search snapshot in history
        {
            $snapshot = $this->snapshotRepository->get($requestedSnapshot);
        } else    // Grab the current snapshot, or redirect if no one exists
        {
            try {
                $snapshot = $this->snapshotRepository->current();
            } catch (RepositoryException $e) {
                if ($e->getCode() == RepositoryException::RESOURCE_NOT_FOUND) {
                    return view('cash.init');
                }

                App::abort(500);
            }
        }

        $snapshotDetails = $this->detailsRepository->fromSnapshot($snapshot->cs_id);
        $allSnapshots = $this->snapshotRepository->all();

        $cashArray = [floatval($snapshot->amount)];
        $lastAmount = $snapshot->amount;

        $lastOperation = 0;
        $cashBySales = 0;
        $salesCount = 0;
        $operationsCount = 0;

        foreach ($snapshotDetails as $detail) {

            $lastAmount += $detail->sum;
            array_push($cashArray, $lastAmount);

            if ($detail->type == 'CASH') {
                $lastOperation = $detail->sum;
                $operationsCount++;
            }

            if ($detail->type == 'SALE') {
                $cashBySales += $detail->sum;
                $salesCount++;
            }
        }

        // Enough data for current snapshot,
        // return all data to the view
        if (!$snapshot->is_closed) {
            return view('cash.app')->with('snapshot', $snapshot)
                ->with('details', $snapshotDetails)
                ->with('amounts', $cashArray)
                ->with('lastOperation', $lastOperation)
                ->with('cashBySales', $cashBySales)
                ->with('allSnapshots', $allSnapshots)
                ->with('salesCount', $salesCount)
                ->with('operationsCount', $operationsCount);
        }

        // Other statistics for closed snapshot

        $nextSnapshot = $this->snapshotRepository->getNext($snapshot->cs_id);

        $snapshotTime = new Carbon($snapshot->time);
        $nextSnapshotTime = new Carbon($nextSnapshot->time);
        $duration = $this->approximateDuration($snapshotTime, $nextSnapshotTime);

        $delta = $nextSnapshot->amount - $snapshot->predicted_amount;

        return view('cash.app')->with('snapshot', $snapshot)
            ->with('details', $snapshotDetails)
            ->with('amounts', $cashArray)
            ->with('cashBySales', $cashBySales)
            ->with('allSnapshots', $allSnapshots)
            ->with('salesCount', $salesCount)
            ->with('operationsCount', $operationsCount)
            ->with('delta', $delta)
            ->with('duration', $duration);
    }

    /**
     * Returns the "rough" duration (seconds, minutes, ...) between two Carbon dates.
     *
     * This function returns a human readable duration such as "5 minutes", "1 month"
     * or "45 seconds". To approximate, it's always the biggest quantifier that is used:
     * 2 months and 5 days would become "2 months".
     *
     * @param Carbon  $oldSnapshotTime    The first Carbon date
     * @param Carbon  $nextSnapshotTime   The second Carbon date
     *
     * @return string
     */
    private function approximateDuration(Carbon $oldSnapshotTime, Carbon $nextSnapshotTime)
    {
        $years = $oldSnapshotTime->diffInYears($nextSnapshotTime);
        if( $years > 0 ) {
            return ($years == 1) ? "1 year" : "$years years";
        }

        $months = $oldSnapshotTime->diffInMonths($nextSnapshotTime);
        if($months > 0 ) {
            return ($months == 1) ? "1 month" : "$months months";
        }

        $days = $oldSnapshotTime->diffInDays($nextSnapshotTime);
        if ($days > 0) {
            return ($days == 1) ? "1 day" : "$days days";
        }

        $hours = $oldSnapshotTime->diffInHours($nextSnapshotTime);
        if ($hours > 0) {
            return ($hours == 1) ? "1 hour" : "$hours hours";
        }

        $minutes = $oldSnapshotTime->diffInMinutes($nextSnapshotTime);
        if($minutes > 0) {
            return ($minutes == 1) ? "1 minute" : "$minutes minutes";
        }

        $seconds = $oldSnapshotTime->diffInSeconds($nextSnapshotTime);
        return ($seconds == 1) ? "1 second" : "$seconds seconds";
    }

    public function operationForm()
    {
        return view('cash.operation');
    }

    public function registerOperation()
    {
        $amount = floatval(Input::get('amount'));
        $currentSnapshotId = $this->snapshotRepository->current()->cs_id;

        $operationData = ['type' => 'CASH',
            'sum' => $amount,
            'time' => time(),
            'cs_id' => $currentSnapshotId,
            'comment' => Input::get('comment')];

        try {
            $this->detailsRepository->store($operationData);
        } catch (RepositoryException $e) {
            return Redirect::to('app/cash/register-operation')->with('error', 'Could not save operation: ' . $e->getMessage())
                ->withInput();
        }

        $message = ($amount < 0) ? 'removed ' . abs($amount) . '&euro; from drawer' : 'added ' . $amount . '&euro; in drawer';
        return Redirect::to('app/cash')->with('success', 'Cash operation saved: ' . $message);
    }

    public function snapshotForm()
    {
        return view('cash.snapshot');
    }

    public function createSnapshot()
    {
        $title = Input::get('title');

        try {
            $this->snapshotRepository->store(Input::all());
        } catch (RepositoryException $e) {
            return Redirect::to('app/cash/new-snapshot')->with('error', 'Error while creating snapshot: ' . $e->getMessage())
                ->withInput();
        }

        return Redirect::to('app/cash')->with('success', "Cash snapshot <i>$title</i> created");
    }

    public function showHistory()
    {
        try {
            $snapshots = $this->snapshotRepository->history();
        } catch (RepositoryException $e) {
            App::abort(500);
        }

        return view('cash.history')->with('snapshots', $snapshots);
    }

    public function removeDetail($id)
    {
        try {

            DB::beginTransaction();

            $detailData = $this->detailsRepository->get($id);
            $this->detailsRepository->delete($id);
            $this->snapshotRepository->updatePredictedAmount($detailData->cs_id);

            DB::commit();

        } catch (RepositoryException $e) {
            return redirect('app/cash')->with('error', 'An error occurred: ' . strtolower($e->getMessage()));
        }

        return redirect('app/cash')->with('success', "Snapshot item removed");
    }

}

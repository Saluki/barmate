<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\CashSnapshots;
use Auth;
use DB;
use Exception;
use Session;
use Validator;

class SnapshotRepository extends Repository {

    function getModelName()
    {
        return 'App\Models\CashSnapshots';
    }

	public function all()
	{
		try {
			return $this->model->where('group_id', '=', Session::get('groupID') )
									->orderBy('time','desc')
									->get();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}

	public function history()
	{
		try {
			return $this->model->where('group_id', '=', Session::get('groupID') )
									->where('is_closed',true)
									->orderBy('time','desc')
									->get();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}

	public function get($id)
	{
		$this->validateID($id);

		$snapshot = NULL;
		try {
			$snapshot = $this->model->where('group_id', '=', Session::get('groupID'))
										->where('cs_id', '=', $id)
										->first();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}

		if( $snapshot == NULL )
			throw new RepositoryException('Snapshot with ID '.$id.' not found', RepositoryException::RESOURCE_NOT_FOUND);
		
		return $snapshot;	
	}

    public function getNext($id)
    {
        $this->validateID($id);

        try {
            $snapshot = $this->model->where('cs_id', '>', $id)->orderBy('cs_id')->firstOrFail();
        }
        catch(Exception $e) {
            throw new RepositoryException('Could not retrieve next record', RepositoryException::DATABASE_ERROR);
        }

        return $snapshot;
    }

	public function store(array $data)
	{
		$this->validate($data);

		$snapshot = new CashSnapshots();

		$snapshot->snapshot_title = $data['title'];
		$snapshot->description    = $data['description'];
		$snapshot->amount         = $data['amount'];
		$snapshot->time           = date('Y-m-d H:i:s');
		$snapshot->group_id       = Session::get('groupID');
		$snapshot->user_id        = Auth::id();
		$snapshot->is_closed      = false;

		try {

			$this->closeLastSnapshot();

			$snapshot->save();
			$snapshot->id = DB::getPdo()->lastInsertId();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}

		return $snapshot;
	}

	public function current()
	{
		$snapshot = NULL;
		try {
			$snapshot = $this->model->where('group_id', '=', Session::get('groupID'))
										->where('is_closed', '=', false)
										->orderBy('time', 'desc')
										->first();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}

		if( $snapshot == NULL )
			throw new RepositoryException('Current snapshot not found', RepositoryException::RESOURCE_NOT_FOUND);

		return $snapshot;
	}

	private function closeLastSnapshot()
	{
		$lastSnapshot = $this->model->where('group_id','=',Session::get('groupID'))
										->where('is_closed','=',false)
										->orderBy('time','desc')
										->first();

		if( $lastSnapshot == NULL )
			return;

		$lastSnapshot->is_closed = true;
		$lastSnapshot->predicted_amount = $this->computePredictedAmount($lastSnapshot->cs_id, $lastSnapshot->amount);

		$lastSnapshot->save();
	}

	private function computePredictedAmount($snapshotID, $originalAmount)
	{
		$details = $this->model->findOrFail($snapshotID)
								->details()
								->get();

		$predictedAmount = $originalAmount;
		foreach ($details as $detail) {
			
			$predictedAmount += $detail->sum;
		}

		return $predictedAmount;
	}

	public function APIFormat($object)
	{
		if( !is_object($object) )
			return null;

		if( get_class($object) === 'CashSnapshots' )
			return $this->formatRecord( $object );

		$responseArray = [];
		foreach ($object as $record) {

			array_push($responseArray, $this->formatRecord( $record ));
		}

		return $responseArray;
	}

	private function formatRecord($object) {

		$formatted = new stdClass();
			
		$formatted->id          = intval($object->cs_id);
		$formatted->user        = intval($object->user_id);
		$formatted->amount      = floatval($object->amount);

		$formatted->title       = $object->snapshot_title;
		$formatted->description = $object->description;
		$formatted->time        = $object->time;

		if( $object->predicted_amount == NULL ) {
			$formatted->predicted = NULL;
		}
		else {
			$formatted->predicted = floatval($object->predicted_amount);
		}

		$formatted->closed = (bool) $object->is_closed;

		return $formatted;
	}

	public function validate(array $data)
	{
		$rules = CashSnapshots::$validationRules;

		$validator = Validator::make($data, $rules);

		if( $validator->fails() ) {
			throw new RepositoryException('Validation failed', RepositoryException::VALIDATION_FAILED);
		}
	}
}
<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\SnapshotDetails;
use Session;
use Auth;
use Validator;

class SnapshotDetailsRepository extends Repository {

    function getModelName()
    {
        return 'App\Models\SnapshotDetails';
    }

	public function fromSnapshot($id)
	{
		$this->validateID($id);

		try {
			return $this->model->group( Session::get('groupID') )
									->where('snapshot_details.cs_id', '=', $id)
									->get();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}

    public function APIFormat($object)
	{
		if( !is_object($object) )
			return null;

		if( get_class($object) === 'SnapshotDetails' )
			return $this->formatRecord( $object );

		$responseArray = [];
		foreach ($object as $record) {

			array_push($responseArray, $this->formatRecord( $record ));
		}

		return $responseArray;
	}

    public function store(array $data)
    {
        $this->validate($data);

        try {
            $detail = new SnapshotDetails();

            $detail->type    = $data['type'];
            $detail->sum     = floatval($data['sum']);
            $detail->time    = date('Y-m-d G:i:s', $data['time']);
            $detail->user_id = Auth::id();
            $detail->sale_id = $data['sale_id'];
            $detail->cs_id   = $data['cs_id'];

            $detail->save();
        }
        catch(\Exception $e) {
            throw new RepositoryException('Could not save snapshot detail in database', RepositoryException::DATABASE_ERROR);
        }
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data,
            [
                'type'    => 'required|in:SALE,CASH',
                'sum'     => 'required|numeric|min:0',
                'time'    => 'required|integer|min:0',
                'sale_id' => 'required|integer|min:0',
                'cs_id'   => 'required|integer|min:0'
            ]
        );

        if( $validator->fails() ) {
            throw new RepositoryException('Cash snapshot detail validation failed', RepositoryException::VALIDATION_FAILED);
        }
    }

    private function formatRecord($object) {

		$formatted = new stdClass();
			
		$formatted->id          = intval($object->csd_id);
		$formatted->user        = intval($object->user_id);
		$formatted->sale        = intval($object->sale_id);
		$formatted->sum         = floatval($object->sum);

		$formatted->type        = $object->type;
		$formatted->comment     = $object->comment;
		$formatted->time        = $object->time;

		return $formatted;
	}

}
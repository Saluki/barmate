<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\SnapshotDetails;
use Session;

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
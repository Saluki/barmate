<?php

use App\Exceptions\RepositoryException;
use App\Repositories\SnapshotDetailsRepository;
use App\Repositories\SnapshotRepository;
use Input;
use Response;

class SnapshotController extends \Controller {
	
	protected $repository;

	public function __construct(SnapshotRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		$snapshots = $this->repository->all();
		return Response::json( $this->repository->APIFormat($snapshots), 200);
	}

	public function store()
	{		
		$snapshot = $this->repository->store( Input::all() );
		return Response::json( ['id' => $snapshot->id], 200);
	}

	public function show($id)
	{
		$snapshot = $this->repository->get($id);
		return Response::json($this->repository->APIFormat($snapshot), 200);
	}

	public function getCurrent()
	{
		$snapshot = $this->repository->current();
		return Response::json($this->repository->APIFormat($snapshot), 200);
	}

	public function getDetails($id)
	{
		$repository = new SnapshotDetailsRepository();

		$details = $repository->fromSnapshot($id);
		return Response::json($repository->APIFormat($details), 200);
	}

}

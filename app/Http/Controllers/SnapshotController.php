<?php

class SnapshotController extends \Controller {

	public function __construct(SnapshotRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		try {

			$snapshots = $this->repository->all();
			return Response::json( $this->repository->APIFormat($snapshots), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	public function store()
	{		
		try {

			$snapshot = $this->repository->store( Input::all() );
			return Response::json( ['id' => $snapshot->id], 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	public function show($id)
	{
		try {

			$snapshot = $this->repository->get($id);
			return Response::json($this->repository->APIFormat($snapshot), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	public function getCurrent()
	{
		try {

			$snapshot = $this->repository->current();
			return Response::json($this->repository->APIFormat($snapshot), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

	public function getDetails($id)
	{
		$repository = new SnapshotDetailsRepository();

		try {

			$details = $repository->fromSnapshot($id);
			return Response::json($repository->APIFormat($details), 200);
		}
		catch(RepositoryException $e) {

			return $e->jsonResponse();
		}
	}

}

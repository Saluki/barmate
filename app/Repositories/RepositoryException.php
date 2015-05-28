<?php namespace App\Repositories;

use \Exception;

class RepositoryException extends Exception {

	// Server Side
	const DATABASE_ERROR = 11;

	// Client side
	const INCORRECT_PARAMETER = 21;
	const VALIDATION_FAILED = 22;
	const RESOURCE_NOT_FOUND = 23;
	const RESOURCE_DENIED = 24;

	// Matching status
	private static $httpStatus = [  self::DATABASE_ERROR      => 503,
							   		self::INCORRECT_PARAMETER => 400,
									self::VALIDATION_FAILED   => 400,
									self::RESOURCE_NOT_FOUND  => 404,
									self::RESOURCE_DENIED     => 403 ];

	public function APIFormat() {

		return ['code' => $this->code, 'message' => $this->message ];
	}

	public function jsonResponse() {

		$statusCode = 500;

		if( isset( $httpStatus[$this->code] ) ) 
		{
			$statusCode = $httpStatus[ $this->code ];
		}

		return Response::json( $this->APIFormat(), $statusCode);
	}

}

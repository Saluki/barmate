<?php namespace App\Services;

class ExtendedValidationService {
	
	public function validatePassword($field, $value, $params)
    {
		return (bool) preg_match("/^[a-zA-Z0-9\@\!\#\$\%\?]{5,50}$/", $value);
	}

	public function validateName($field, $value, $params)
    {
		return (bool) preg_match("/^[a-z A-Z0-9\-]{1,50}$/", $value);
	}

}
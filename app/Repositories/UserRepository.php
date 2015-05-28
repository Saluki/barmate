<?php namespace App\Repositories;

use App\User;
use App\Repositories\RepositoryException;
use \Session, \Exception, \Hash, \DB, \Validator;

class UserRepository {

	public function all() {

		try {
			return User::fromGroup()->get();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}
	
	public function allByStatus($isActive) {
	
		if(!is_bool($isActive))
			throw new RepositoryException('Must be a boolean', RepositoryException::INCORRECT_PARAMETER);
		
		try {
			return User::fromGroup()->where('is_active', $isActive)->orderBy('role', 'DESC')->get();
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}

	public function get($id) {

		if( !is_numeric($id) )
			throw new RepositoryException('Invalid user ID', RepositoryException::INCORRECT_PARAMETER);
		
		try {
			$user = User::fromGroup()->find($id);
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
		
		if( $user==null )
			throw new RepositoryException('User not found', RepositoryException::RESOURCE_NOT_FOUND);
		
		return $user;
	}
	
	public function findActive($email) {

		if( is_null($email) || !is_string($email) )
        	throw new RepositoryException('Incorrect email adress', RepositoryException::VALIDATION_FAILED);

        try {
        	$user = User::activeGroup()->where('email','=',$email)->where('users.is_active',true)->first();
        }
        catch(Exception $e) {
        	throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
        }

        if( $user==null )
        	throw new RepositoryException('User not found', RepositoryException::RESOURCE_NOT_FOUND);

        return $user;
	}

	public function changeStatus($userId) {

		$user = $this->get($userId);
		
		try {
			
			if($user->role=='ADMN')
				throw new RepositoryException('Cannot change status of administrator', RepositoryException::RESOURCE_DENIED);
			
			$user->is_active = !$user->is_active;
			$user->save();
			
			return $user->is_active;
		}
		catch(Exception $e) {
			
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}
	
	public function changeRole($userId) {
		
		$user = $this->get($userId);
		
		try {
			
			if( $user->role=='ADMN' )
				throw new RepositoryException('Cannot change role of administrator', RepositoryException::RESOURCE_DENIED);
			
			if( $user->role=='USER')
				$user->role='MNGR';
			else
				$user->role='USER';
			
			$user->save();
			return $user;
		}
		catch(Exception $e) {
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
	}
	
	public function store($data) {
		
		$this->validate($data);
		
		if( $data['role']!='USER' && $data['role']!='MNGR' )
			throw new RepositoryException('Invalid role name', RepositoryException::VALIDATION_FAILED);
		
		$user = new User();
		
		$user->firstname = $data['firstname'];
		$user->lastname = $data['lastname'];
		$user->group_id = Session::get('groupID');
		$user->email = $data['email'];
		$user->password_hash = Hash::make('password');
		$user->role = $data['role'];
		$user->inscription_date = date('Y-m-d H:i:s');
		
		try {
			$user->save();
		}
		catch(Exception $e) {			
			throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
		}
		
		$user->id = DB::getPdo()->lastInsertId();
		return $user;		
	}
	
	public function softDelete($userId)
	{
		$user = $this->get($userId);
		
		if( $user->role=='ADMN' )
			throw new RepositoryException('Cannot delete administrator', RepositoryException::RESOURCE_DENIED);
		
		try {
			$user->delete();
		}
		catch(Exception $e) {
						
			throw new RepositoryException('Database error #'.$e->getCode(), RepositoryException::DATABASE_ERROR);
		}
		
		return $user;
	}
	
	public function validate($data)
	{
		$rules = User::$validationRules;
		
		$validator = Validator::make($data, $rules);
		
		if($validator->fails()) {
			throw new RepositoryException('Validation failed', RepositoryException::VALIDATION_FAILED);
		}
	}
	
}
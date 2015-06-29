<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Repositories\UserRepository;
use Input;

class UsersController extends Controller {
	
	private $userRepository;

	public function __construct(UserRepository $repository) 
	{
		$this->userRepository = $repository;
	}

    public function getActiveUsers()
    {
    	$allUsers = $this->userRepository->allByStatus(true);
        $otherUsersCount = count($this->userRepository->allByStatus(false));

        return view('users.app')->with('users', $allUsers)
        						->with('roles', $this->getRoleNames())
        						->with('isActive', true)
                                ->with('otherUsersCount', $otherUsersCount);
    }
    
    public function getDisabledUsers()
    {
    	$allUsers = $this->userRepository->allByStatus(false);
        $otherUsersCount = count($this->userRepository->allByStatus(true));

    	return view('users.app')->with('users', $allUsers)
    							->with('roles', $this->getRoleNames())
    							->with('isActive', false)
                                ->with('otherUsersCount', $otherUsersCount);
    }
    
    public function getRegisterForm()
    {
    	return view('users.register');
    }
    
    public function registerNewUser()
    {
    	try {
    		$user = $this->userRepository->store(Input::all());
    	}
        catch (RepositoryException $e) {
    		return redirect('app/users/register')->with('error', 'Could not add user: '.$e->getMessage());
    	}
    	    	
    	return redirect('app/users')->with('success', 'User account for '.$user->firstname.' created');
    }
    
    public function changeAccountStatus($userId)
    {    	
    	try {
    		$isActive = $this->userRepository->changeStatus($userId);
    	}
    	catch(RepositoryException $e) {
    		return redirect('app/users')->with('error', 'Could not change status of account');
    	}
    	
    	if($isActive)
    		return redirect('app/users/disabled')->with('success', 'Account is now enabled');
    	else
    		return redirect('app/users')->with('success', 'Account is now disabled');
    }
    
    public function changeAccountRole($userId)
    {
    	try {
    		$user = $this->userRepository->changeRole($userId);
    	}
    	catch(RepositoryException $e) {
    		return redirect('app/users')->with('error', 'Could not change user role');
    	}
    	
    	$redirectUrl = 'app/users';
    	if( !$user->is_active )
    		$redirectUrl .= '/disabled';
    	
    	$roleNames = ['ADMN'=>'administrator','MNGR'=>'manager','USER'=>'user'];
    	$roleName = $roleNames[$user->role];
    	
    	return redirect($redirectUrl)->with('success', $user->firstname.' has now the role <i>'.$roleName.'</i>');
    }
    
    public function deleteUser($userId)
    {
    	try {
    		$user = $this->userRepository->softDelete($userId);
    	}
    	catch(RepositoryException $e) {
    		return redirect('app/users')->with('error', 'User could not be deleted: '.$e->getMessage());
    	}
    	
    	return redirect('app/users')->with('success', 'User '.$user->firstname.' has been deleted');
    }

    private function getRoleNames()
    {
        return ['ADMN'=>'Administrator','MNGR'=>'Manager','USER'=>'User'];
    }

}

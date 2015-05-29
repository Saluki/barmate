<?php namespace App\Http\Controllers;

use App\Models\ConnectHistory;
use App\Exceptions\RepositoryException;
use App\Repositories\UserRepository;
use Auth;
use Hash;
use Input;
use Redirect;
use Request;
use Session;
use Validator;

class LoginController extends Controller {
	
	private $userRepository;
	
	public function __construct(UserRepository $repository)
	{
		$this->userRepository = $repository;
	}

	public function loginForm()
	{
		return view('public.login');	
	}
    
    public function tryLogin()
    {        
        $validator = Validator::make(Input::all(), [

            'email'  => 'required|email',
            'password'  => 'required|password'
        ]);

        $email = Input::get('email');
                
        if( $validator->fails() ) {

            return Redirect::to('login')->withError('Credentials have wrong format')
                                        ->withEmail( $email );
        }

        try 
        {
        	$user = $this->userRepository->findActive($email);
        }
        catch (RepositoryException $e)
        {
        	return Redirect::to('login')->withError('Incorrect credentials')
        								->withEmail( $email );
        }
                        
        if( !Hash::check(Input::get('password'), $user->password_hash) ) 
        {
            return Redirect::to('login')->withError('Incorrect credentials')
                                        ->withEmail( $email );
        }
        
        $connectRecord = new ConnectHistory;
        $connectRecord->user_id      = $user->user_id;
        $connectRecord->email        = $email;
        $connectRecord->connect_ip   = Request::getClientIp();
        $connectRecord->connect_time = date('Y-m-d G:i:s');
        $connectRecord->save();
        
        Auth::loginUsingId( $user->user_id );

        Session::set('groupID', $user->group_id);
        Session::set('role', $user->role);
        
        return Redirect::to('app');
    }
    
    public function logout()
    {
        Auth::logout();
        
        return Redirect::to('login');
    }

}

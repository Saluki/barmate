<?php namespace App\Http\Controllers;

use App\Exceptions\RepositoryException;
use App\Models\ConnectHistory;
use App\Repositories\UserRepository;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Input;
use Session;
use Validator;

class LoginController extends Controller {

	private $userRepository;
	
	public function __construct(UserRepository $repository)
	{
		$this->userRepository = $repository;
	}

	public function getLoginForm()
	{
		return view('public.login');	
	}
    
    public function loginAttempt(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email'  => 'required|email',
            'password'  => 'required|password'
        ]);

        $email = $request->input('email');
                
        if( $validator->fails() )
        {
            return redirect('/')->with('error', 'Your credentials have an invalid format')
                                ->with('email', $email);
        }

        try 
        {
        	$user = $this->userRepository->findActive($email);
        }
        catch (RepositoryException $e)
        {
        	return redirect('/')->with('error', 'The email and password you entered don\'t match')
                                ->with('email', $email);
        }
                        
        if( !Hash::check(Input::get('password'), $user->password_hash) ) 
        {
            return redirect('/')->with('error', 'The email and password you entered don\'t match')
                                ->with('email', $email);
        }
        
        $connectRecord = new ConnectHistory;
        $connectRecord->user_id      = $user->user_id;
        $connectRecord->email        = $email;
        $connectRecord->connect_ip   = $request->getClientIp();
        $connectRecord->connect_time = Carbon::now();
        $connectRecord->save();
        
        Auth::loginUsingId($user->user_id);

        Session::put('groupID', $user->group_id);
        Session::put('role', $user->role);

        return redirect('app');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}

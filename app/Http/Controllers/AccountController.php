<?php namespace App\Http\Controllers;

use App;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Validator;

class AccountController extends Controller {

    public function index()
    {    
        $userData = User::profileData(Auth::id());
        
        if( $userData == null )
        {
            App::abort(500, 'User does not exist');
        }

        $roles = ['USER'=>'User', 'MNGR'=>'Manager', 'ADMN'=>'Administrator'];
        $userData->role = $roles[ $userData->role ];

        return view('account.main')->with('user', $userData);
    }
    
    public function saveProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'firstname'       => 'required|name',
            'lastname'        => 'required|name',
            'email'           => 'required|email',
            'npassword'       => 'password'
        ]);
        
        if( $validator->fails() )
        {
            $messages = $validator->messages();
            return redirect('app/account')->with('error', $messages->all()[0] );
        }

        $user = User::find(Auth::id());

        if( $request->input('npassword') != '' )
        {
            if( $request->input('npassword') != $request->input('npasswordrepeat') )
            {
                return redirect('app/account')->with('error', 'New passwords doesn\'t match');
            }

            $user->password_hash = Hash::make($request->input('npassword'));
        }

        $user = User::find( Auth::id() );
        $user->firstname = $request->input('firstname');
        $user->lastname  = $request->input('lastname');
        $user->email     = $request->input('email');
        $user->notes     = $request->input('notes');

        try
        {
            $user->save();
        }
        catch(Exception $e)
        {
            $errorMessage = 'Database error';
           
            if( $e->getCode() == 23000 )
            {
                $errorMessage = 'Email is already in use';
            }

            return redirect('app/account')->with('error', $errorMessage);
        }

        return redirect('app/account')->with('success', 'Account settings updated');
    }

}

<?php namespace App\Http\Controllers;

use App;
use App\User;
use Auth;
use Hash;
use Input;
use Redirect;
use Validator;

class AccountController extends Controller {

    public function index()
    {    
        $userData = User::profileData( Auth::id() );
        
        if( $userData == null )
            App::abort(500, 'User does not exist');

        $roles = ['USER'=>'User', 'MNGR'=>'Manager', 'ADMN'=>'Administrator'];
        $userData->role = $roles[ $userData->role ];

        return view('account.main')->withUser($userData);
    }
    
    public function saveProfile()
    {
        $validator = Validator::make(Input::all(), [
           
            'firstname'       => 'required|name',
            'lastname'        => 'required|name',
            'email'           => 'required|email',
            'npassword'       => 'password'
        ]);
        
        if( $validator->fails() ) {

            $messages = $validator->messages();

            return Redirect::to('app/account')->withError( $messages->all()[0] );
        }

        $user = User::find( Auth::id() );

        if( Input::get('npassword') != '' ) {

            if( Input::get('npassword') != Input::get('npasswordrepeat') ) {
                return Redirect::to('app/account')->withError('New passwords doesn\'t match');
            }

            $user->password_hash = Hash::make( Input::get('npassword') );
        }

        $user = User::find( Auth::id() );
        $user->firstname = Input::get('firstname');
        $user->lastname  = Input::get('lastname');
        $user->email     = Input::get('email');
        $user->notes     = Input::get('notes');

        try {
            $user->save();
        }
        catch(Exception $e) {

            $errorMessage = 'Database error';
           
            if( $e->getCode() == 23000 )
                $errorMessage = 'Email is already in use';

            return Redirect::to('app/account')->withError($errorMessage);
        }

        return Redirect::to('app/account')->withSuccess('Account settings updated');
    }
}

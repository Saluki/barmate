<?php

namespace App\Http\Controllers;

use App;
use App\Repositories\UserRepository;
use App\Exceptions\ValidationException;
use App\Exceptions\RepositoryException;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Validator;
use Exception;

class AccountController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $userData = $this->userRepository->get(auth()->id());
        $userData->role = $this->getRoleName($userData->role);

        return view('account.main')->with('user', $userData);
    }

    public function saveProfile(Request $request)
    {
        try {
            $this->userRepository->updateAccount(auth()->id(), $request->all());
        }
        catch(ValidationException $e) {
            return redirect('app/account')->with('error', $e->getMessageBag()->first());
        }
        catch(RepositoryException $e) {
            return redirect('app/account')->with('error', 'Could not update settings: '.strtolower($e->getMessage()));
        }

        return redirect('app/account')->with('success', 'Account settings updated');
    }

    private function getRoleName($roleName)
    {
        $roles = ['USER' => 'User', 'MNGR' => 'Manager', 'ADMN' => 'Administrator'];
        return $roles[$roleName];
    }
}

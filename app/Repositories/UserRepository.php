<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Exceptions\ValidationException;
use App\User;
use DB;
use Exception;
use Hash;
use Session;
use Validator;
use Carbon\Carbon;

class UserRepository extends Repository
{
    function getModelName()
    {
        return 'App\User';
    }

    public function all()
    {
        try {
            return $this->model->fromGroup()->get();
        } catch (Exception $e) {
            throw new RepositoryException('Database error occurred', RepositoryException::DATABASE_ERROR);
        }
    }

    public function allByStatus($isActive)
    {
        if (!is_bool($isActive)) {
            throw new RepositoryException('Must be a boolean', RepositoryException::INCORRECT_PARAMETER);
        }

        try {
            return $this->model->fromGroup()->where('is_active', $isActive)->orderBy('role', 'DESC')->get();
        } catch (Exception $e) {
            throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
        }
    }

    public function get($id)
    {
        $this->validateID($id);

        try {
            $user = $this->model->fromGroup()->find($id);
        } catch (Exception $e) {
            throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
        }

        if (empty($user)) {
            throw new RepositoryException('User not found', RepositoryException::RESOURCE_NOT_FOUND);
        }

        return $user;
    }

    public function findActive($email)
    {
        if (is_null($email) || !is_string($email)) {
            throw new RepositoryException('Incorrect email address', RepositoryException::VALIDATION_FAILED);
        }

        try {
            $user = $this->model->activeGroup()
                ->where('email', '=', $email)
                ->where('users.is_active', true)
                ->first();
        } catch (Exception $e) {
            throw new RepositoryException('Database error occurred', RepositoryException::DATABASE_ERROR);
        }

        if (empty($user)) {
            throw new RepositoryException('User not found', RepositoryException::RESOURCE_NOT_FOUND);
        }

        return $user;
    }

    public function changeStatus($userId)
    {
        $user = $this->get($userId);

        try {
            if ($user->role == 'ADMN') {
                throw new RepositoryException('Cannot change status of administrator', RepositoryException::RESOURCE_DENIED);
            }

            $user->is_active = !$user->is_active;
            $user->save();
        } catch (Exception $e) {
            throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
        }

        return $user;
    }

    public function changeRole($userId)
    {
        $user = $this->get($userId);

        try {

            if ($user->role == 'ADMN') {
                throw new RepositoryException('Cannot change role of administrator', RepositoryException::RESOURCE_DENIED);
            }

            if ($user->role == 'USER') {
                $user->role = 'MNGR';
            } else {
                $user->role = 'USER';
            }

            $user->save();

        } catch (Exception $e) {
            throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
        }

        return $user;
    }

    public function store(array $data)
    {
        $this->validate($data);

        if ($data['role'] != 'USER' && $data['role'] != 'MNGR') {
            throw new RepositoryException('Invalid role name', RepositoryException::VALIDATION_FAILED);
        }

        $user = new User();

        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->group_id = Session::get('groupID');
        $user->email = $data['email'];
        $user->password_hash = Hash::make($data['password']);
        $user->role = $data['role'];
        $user->inscription_date = Carbon::now()->toDateTimeString();

        try {
            $user->save();
        } catch (Exception $e) {
            throw new RepositoryException('Database error', RepositoryException::DATABASE_ERROR);
        }

        $user->id = DB::getPdo()->lastInsertId();
        return $user;
    }

    public function updateAccount($userId, array $userData)
    {
        $this->validateID($userId);

        $validator = Validator::make($userData, [
            'firstname' => 'required|name',
            'lastname' => 'required|name',
            'email' => 'required|email',
            'password' => 'password',
            'repeat_password' => 'same:password',
            'notes' => '',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        try {
            $userAccount = $this->model->find($userId);
        } catch (Exception $e) {
            throw new RepositoryException('Could not retrieve user account', RepositoryException::DATABASE_ERROR);
        }

        $userAccount->firstname = $userData['firstname'];
        $userAccount->lastname = $userData['lastname'];
        $userAccount->notes = $userData['notes'];

        if (!empty($userData['password'])) {
            $userAccount->password_hash = Hash::make($userData['password']);
        }

        if ($userAccount->email != $userData['email']) {

            $emailValidator = Validator::make($userData, [
                'email' => 'unique:users,email'
            ]);

            if ($emailValidator->fails()) {
                throw new ValidationException($emailValidator->errors());
            }

            $userAccount->email = $userData['email'];
        }

        try {
            $userAccount->save();
        } catch (Exception $e) {
            throw new RepositoryException('Could not update account settings', RepositoryException::DATABASE_ERROR);
        }
    }

    public function softDelete($userId)
    {
        $user = $this->get($userId);

        if ($user->role == 'ADMN')
            throw new RepositoryException('Cannot delete administrator', RepositoryException::RESOURCE_DENIED);

        try {
            $user->delete();
        } catch (Exception $e) {

            throw new RepositoryException('Database error #' . $e->getCode(), RepositoryException::DATABASE_ERROR);
        }

        return $user;
    }

    public function validate(array $data)
    {
        $rules = User::$validationRules;

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }
    }

}
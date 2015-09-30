<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;

class ConnectRepository extends Repository {

    public function getModelName()
    {
        return 'App\Models\ConnectHistory';
    }

    public function forUser($userId)
    {
        $this->validateID($userId);

        try
        {
            $connections = $this->model->where('user_id', '=', $userId)->orderBy('connect_time', 'DESC')->get();
        }
        catch(\Exception $e)
        {
            throw new RepositoryException('Could not fetch connections for user #'.$userId, RepositoryException::DATABASE_ERROR);
        }

        return $connections;
    }

}
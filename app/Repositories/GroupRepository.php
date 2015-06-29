<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use Exception;

class GroupRepository extends Repository {

    function getModelName()
    {
        return 'App\Models\Groups';
    }

    public function get($groupId=-1)
    {
        if( $groupId==-1 ) {
            $groupId = session('groupID');
        }
        else {
            $this->validateID($groupId);
        }

        try {
            $group = $this->model->findOrFail($groupId);
        }
        catch(Exception $e) {
            throw new RepositoryException('Could not find group with ID '.$groupId, RepositoryException::DATABASE_ERROR);
        }

        return $group;
    }

}
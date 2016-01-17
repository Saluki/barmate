<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Exceptions\RepositoryException;

abstract class Repository implements RepositoryInterface {

    protected $model;

    public function __construct(App $app)
    {
        $model = $app->make($this->getModelName());

        if( !$model instanceof Model ) {
            throw new RepositoryException('Model must be an instance of Illuminate\\Database\\Eloquent\\Model');
        }

        $this->model = $model;
    }

    public abstract function getModelName();

    public function all()
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function get($id)
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function store(array $data)
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function update($id, array $data)
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function delete($id)
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function softDelete($id)
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function validate(array $data)
    {
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);
    }

    public function validateID($id)
    {
        if( (bool) preg_match('/^[0-9]{1,10}$/', $id) === false )
        {
            throw new RepositoryException('Parameter must be a positive integer', RepositoryException::INCORRECT_PARAMETER);
        }
    }


}
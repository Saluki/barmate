<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use DB;
use Session;

class CategoryRepository extends Repository
{
    public function getModelName()
    {
        return 'App\Models\Categories';
    }

    public function get($id)
    {
        $this->validateID($id);

        try {
            $category = $this->model->find($id);
        }
        catch(\Exception $e) {
            throw new RepositoryException('Could not retrieve category', RepositoryException::DATABASE_ERROR);
        }

        if( $category==NULL ) {
            throw new RepositoryException('Category not found', RepositoryException::RESOURCE_NOT_FOUND);
        }

        return $category;
    }

    public function allWithProducts()
    {
        $query = 'SELECT p.product_id as "id", p.product_name as "name", c.category_title as "group", p.price
					FROM categories c
					LEFT JOIN products p ON c.category_id = p.category_id
					WHERE p.deleted_at IS NULL
					AND c.deleted_at IS NULL
					AND c.group_id = ?';

        return DB::select($query, [ Session::get('groupID') ]);
    }
}
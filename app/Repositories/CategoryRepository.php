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
        } catch (\Exception $e) {
            throw new RepositoryException('Could not retrieve category', RepositoryException::DATABASE_ERROR);
        }

        if ($category == NULL) {
            throw new RepositoryException('Category not found', RepositoryException::RESOURCE_NOT_FOUND);
        }

        return $category;
    }

    public function store(array $data)
    {
        if ($this->contains($data['title'])) {
            throw new RepositoryException('Category name already exists', RepositoryException::DATABASE_ERROR);
        }

        try {

            $this->model->create([
                'group_id' => session('groupID'),
                'category_title' => $data['title'],
                'description' => $data['description'],
                'is_active' => true
            ]);

        } catch (\Exception $e) {
            throw new RepositoryException($e->getMessage(), RepositoryException:: DATABASE_ERROR);
        }

        return DB::getPdo()->lastInsertId();
    }

    public function contains($categoryTitle)
    {
        $category = $this->model->where('category_title', '=', $categoryTitle)->first();

        return $category != null;
    }

    public function allWithProducts()
    {
        $query = 'SELECT p.product_id as "id", p.product_name as "name", c.category_title as "group", p.price
					FROM categories c
					LEFT JOIN products p ON c.category_id = p.category_id
					WHERE p.deleted_at IS NULL
					AND c.deleted_at IS NULL
					AND c.group_id = ?';

        return DB::select($query, [Session::get('groupID')]);
    }

    public function allAPI()
    {
        $query = 'SELECT c.category_id as "id", c.category_title as "title",
    				c.description, c.is_active as "active", c.created_at as "created"
					FROM categories c
					WHERE c.group_id = ?
					AND c.deleted_at IS NULL';

        return DB::select($query, [ Session::get('groupID') ]);
    }
}
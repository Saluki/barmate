<?php namespace App\Repositories;

interface RepositoryInterface {

    public function all();

    public function get($id);

    public function store(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function softDelete($id);

    public function validate(array $data);

}
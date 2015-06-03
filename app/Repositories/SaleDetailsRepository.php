<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\SaleDetails;

class SaleDetailsRepository extends Repository{

    function getModelName()
    {
        return 'App\Models\SaleDetails';
    }

    public function store(array $data)
    {
        $this->validate($data);

        try
        {
            $detail = new SaleDetails();

            $detail->sale_id = intval($data['sale']);
            $detail->product_id = intval($data['id']);
            $detail->quantity = intval($data['quantity']);
            $detail->current_price = floatval($data['price']);

            $detail->save();
        }
        catch(\Exception $e)
        {
            throw new RepositoryException("Could not store sale detail: ".$e->getMessage(), RepositoryException::DATABASE_ERROR);
        }
    }

    public function validate(array $data)
    {
        // TODO Validation
    }

}
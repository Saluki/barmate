<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\SaleDetails;
use Validator;

class SaleDetailsRepository extends Repository{

    public function getModelName()
    {
        return 'App\Models\SaleDetails';
    }

    public function store(array $data)
    {
        $this->validate($data);

        try
        {
            $detail = new SaleDetails();

            $detail->sale_id       = intval($data['sale_id']);
            $detail->product_id    = intval($data['product_id']);
            $detail->quantity      = intval($data['quantity']);
            $detail->current_price = floatval($data['current_price']);

            $detail->save();
        }
        catch(\Exception $e)
        {
            throw new RepositoryException("Could not store sale detail: ".$e->getMessage(), RepositoryException::DATABASE_ERROR);
        }
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data,
            [
                'sale_id'       => 'required|integer|min:0',
                'product_id'    => 'required|integer|min:0',
                'quantity'      => 'required|integer|min:0',
                'current_price' => 'required|numeric|min:0'
            ]
        );

        if( $validator->fails() ) {
            throw new RepositoryException('Sale detail validation failed', RepositoryException::VALIDATION_FAILED);
        }
    }

}
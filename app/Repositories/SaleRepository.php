<?php namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Models\Sales;
use Auth;
use DB;
use Exception;
use Session;

class SaleRepository extends Repository {

    function getModelName()
    {
        return 'App\Models\Sales';
    }

	public function register(array $saleData)
	{
        $this->validate($saleData);

        try
        {
            $sale = new Sales();
            $sale->group_id = Session::get('groupID');
            $sale->user_id = Auth::id();
            $sale->time = date('Y-m-d G:i:s', $saleData['timestamp']);
            $sale->sum = $saleData['price'];
            $sale->paid = $saleData['cash'];
            $sale->is_active = true;
            $sale->save();

            return DB::getPdo()->lastInsertId();
        }
        catch(Exception $e)
        {
            throw new RepositoryException('Could not save sale in database: '.$e->getMessage(), RepositoryException::DATABASE_ERROR);
        }
	}

    public function validate(array $data)
    {
        // TODO Validation
    }

}

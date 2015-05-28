<?php namespace App\Repositories;

use App\Models\Sales;
use App\Repositories\RepositoryException;
use \Auth, \DB, \Session;

class SalesRepository {

	public function register($tempSale)
	{
        try
        {
            $sale = new Sales();
            $sale->group_id = Session::get('groupID');
            $sale->user_id = Auth::id();
            $sale->time = date('Y-m-d G:i:s', $tempSale['timestamp']);
            $sale->sum = $tempSale['price'];
            $sale->paid = $tempSale['cash'];
            $sale->is_active = true;
            $sale->save();
            $sale_id = DB::getPdo()->lastInsertId();

            // Register all sales details entries

            // Generate a new snapshot detail
        }
        catch(\Exception $e)
        {
            throw new RepositoryException('Could not save sale in database: '.$e->getMessage(), RepositoryException::DATABASE_ERROR);
        }
	}
	
}

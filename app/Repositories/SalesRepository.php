<?php namespace App\Repositories;

use App\Models\Sales;
use App\Repositories\RepositoryException;
use \Auth;
use \DB;

class SalesRepository {

    // TODO In one transaction?
	public function register($sale)
	{
        throw new RepositoryException('Not yet implemented', RepositoryException::RESOURCE_DENIED);

        try {

            $sale = new Sales();
            $sale->group_id = Session::get('groupID');
            $sale->user_id = Auth::id();
            $sale->time = date('Y-m-d G:i:s', $sale['timestamp']);
            $sale->sum = $sale['price'];
            $sale->paid = $sale['cash'];
            $sale->is_active = true;

            $sale_id = DB::getPdo()->lastInsertId();

            // Register all sales details entries

            // Generate a new snapshot detail
        }
        catch(\Exception $e) {
            throw new RepositoryException('Could not save sale in database', RepositoryException::DATABASE_ERROR);
        }
	}
	
}

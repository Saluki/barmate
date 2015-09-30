<?php namespace App\Repositories;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Exceptions\RepositoryException;
use App\Models\Sales;
use Auth;
use DB;
use Exception;
use Session;
use Validator;

class SaleRepository extends Repository
{
    public function getModelName()
    {
        return 'App\Models\Sales';
    }

    public function register(array $saleData)
    {
        $this->validate($saleData);

        try {
            $sale = new Sales();

            $sale->group_id = Session::get('groupID');
            $sale->user_id = Auth::id();
            $sale->time = date('Y-m-d G:i:s', $saleData['time']);
            $sale->sum = floatval($saleData['sum']);
            $sale->paid = floatval($saleData['paid']);
            $sale->is_active = true;

            $sale->save();

            return DB::getPdo()->lastInsertId();
        }
        catch (Exception $e)
        {
            throw new RepositoryException('Could not save sale in database: ' . $e->getMessage(), RepositoryException::DATABASE_ERROR);
        }
    }

    public function countByInterval(CarbonInterval $interval)
    {
        $beginDate = Carbon::now()->sub($interval)->addHour();

        if( $interval->d>0 )
        {
            $beginDate = $beginDate->startOfDay();
        }

        $intervals = [];
        $dateCounter = clone $beginDate;
        while($dateCounter <= Carbon::now())
        {
            if( $interval->h>0 )
            {
                $intervals[$dateCounter->hour] = 0;
                $dateCounter->addHour(1);
            }
            else
            {
                $intervals[$dateCounter->day] = 0;
                $dateCounter->addDay(1);
            }
        }

        try
        {
            $sales = $this->model->where('is_active', '=', true)
                                ->where('time', '>=', $beginDate)
                                ->get();
        }
        catch(Exception $e)
        {
            throw new RepositoryException('Could not get sale data', RepositoryException::DATABASE_ERROR);
        }

        foreach($sales as $sale)
        {
            $carbonTimestamp = Carbon::createFromFormat('Y-m-d H:m:s', $sale->time);

            if( $interval->h>0 )
            {
                $intervals[$carbonTimestamp->hour]++;
            }
            else
            {
                $intervals[$carbonTimestamp->day]++;
            }
        }

        return $intervals;
    }

    public function rankUsersByInterval(CarbonInterval $interval)
    {
        $beginDate = Carbon::now()->sub($interval)->addHour();

        if( $interval->d>0 )
        {
            $beginDate = $beginDate->startOfDay();
        }

        try
        {
            $userRank = $this->model->select(['firstname', 'lastname', DB::raw('COUNT(*) as count')])
                ->join('users', 'sales.user_id', '=', 'users.user_id')
                ->where('sales.is_active', '=', true)
                ->where('sales.time', '>=', $beginDate)
                ->groupBy('sales.user_id')
                ->orderBy('count', 'DESC')
                ->take(10)
                ->get();
        }
        catch(Exception $e)
        {
            throw new RepositoryException('Could not retrieve users', RepositoryException::DATABASE_ERROR);
        }

        return $userRank;
    }

    public function validate(array $data)
    {
        $validator = Validator::make($data,
            [
                'time' => 'required|integer|min:0',
                'sum' => 'required|numeric|min:0',
                'paid' => 'required|numeric|min:0'
            ]
        );

        if ($validator->fails()) {
            throw new RepositoryException('Sale data validation failed', RepositoryException::VALIDATION_FAILED);
        }
    }

}

<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashSnapshots extends Model {

	protected $table = 'cash_snapshots';
	public $primaryKey = 'cs_id';
	public $timestamps = false;

	public static $validationRules = [	'title'       => 'required|name',
										'description' => '',
										'amount'      => 'required|numeric|between:0,9999' ];

	public function details()
	{
		return $this->hasMany('App\Models\SnapshotDetails','cs_id');
	}

	public function scopeWithUsers($query)
	{
		$query->join('users', 'users.user_id', 'cash_snapshots.user_id');
	}
	
}
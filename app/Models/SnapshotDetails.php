<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SnapshotDetails extends Model {

	protected $table  = 'snapshot_details';
	public $primaryKey = 'csd_id';
	public $timestamps = false;

	public function scopeGroup($query, $groupID) {

    	$query->join('cash_snapshots', 'cash_snapshots.cs_id', '=', 'snapshot_details.cs_id')
    			->where('cash_snapshots.group_id', $groupID);
    }
	
}
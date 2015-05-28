<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model {

	protected $table = 'groups';
	
	public $timestamps = false;

	protected $guarded = ['group_id']; 

	public function getKeyName(){

        return 'group_id';
    }
	
}
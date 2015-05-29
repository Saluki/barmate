<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Session;

class Categories extends Model {

	use SoftDeletes;

	protected $table = 'categories';
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $guarded = ['category_id'];

	public function getKeyName(){

        return 'category_id';
    }

    public static function allAPI() {

    	$query = 'SELECT c.category_id as "id", c.category_title as "title", 
    				c.description, c.is_active as "active", c.created_at as "created"
					FROM categories c
					WHERE c.group_id = ?
					AND c.deleted_at IS NULL';

		return DB::select($query, [ Session::get('groupID') ]);
    }

	/**
	 * Selects all the categories from the current group
	 *
	 * Allows to extend the query (scope) to only selects the categories from the group 
	 * where the user is connected.
	 * @example Categories::group();
	 *
	 * @param 	Object 	[Laravel]
	 */
	public function scopeFromGroup($query) {

		return $query->where('group_id', Session::get('groupID') );
	}

	/**
	 * Selects all the products from one category
	 *
	 * Easily fetch all the products that belongs to a category. Watch out, 
	 * only works for ONE category.
	 * @example Categories::find(1)->products;
	 *
	 * @return 	Object 	[Laravel]
	 */
	public function products() {

		return $this->hasMany('App\Models\Products', 'category_id', 'category_id');
	}
	
}
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
    protected $fillable = ['group_id', 'category_title', 'description', 'is_active'];

	public function getKeyName(){

        return 'category_id';
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
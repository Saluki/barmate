<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model {

	use SoftDeletes; 

	protected $table      = 'products';
	public    $timestamps = true;
	protected $dates      = ['deleted_at'];
	public    $primaryKey = 'product_id';

	public static $validationRules = [

		'category'    => 'required|integer|min:0',
		'name'        => 'required|name',
		'description' => 'max:250',
		'price'       => 'required|numeric|min:0',
		'quantity'    => 'required|integer|min:0'
	];

    public function category() {

    	return $this->belongsTo('Categories', 'category_id', 'category_id');
    }

    public function scopeGroup($query, $groupID) {

    	$query->select('products.*')
    			->join('categories', 'categories.category_id', '=', 'products.category_id')
    			->where('group_id', $groupID);
    }
	
	// Still used by the App Component.
	public static function getSpecificExtended($id) {

		$query = 'SELECT p.*
					FROM products p
					INNER JOIN categories c ON p.category_id = c.category_id
					WHERE c.category_id = p.category_id
					AND c.group_id = ?
					AND p.product_id = ?';

		$products = DB::select($query, [ Session::get('groupID'), $id ]);

		if( count($products) == 0 )
			return null;

		return $products[0];
	}

}
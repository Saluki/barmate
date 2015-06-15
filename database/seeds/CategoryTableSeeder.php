<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\Models\Categories;

class CategoryTableSeeder extends Seeder {
	
	public function run() {

		$default = Groups::firstOrFail();

		Categories::create(['group_id'        => $default->group_id,
					 		'category_title'  => 'Default',
							'description'     => 'Default category' ]);

	}
}
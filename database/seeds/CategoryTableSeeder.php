<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\Models\Categories;

class CategoryTableSeeder extends Seeder {
	
	public function run() {

		$JH = Groups::where('short_name','=','alleman')->first();
		$jeugdhuisID = $JH->group_id;

		Categories::create(['group_id'        => $jeugdhuisID, 
					 		'category_title'  => 'Pils',
							'description'     => 'Belgisch pils' ]);

		Categories::create(['group_id'        => $jeugdhuisID, 
					 		'category_title'  => 'Speciaal' ]);

		Categories::create(['group_id'        => $jeugdhuisID, 
					 		'category_title'  => 'Snack' ]);

	}
}
<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;

class GroupTableSeeder extends Seeder {
	
	public function run() {

		Groups::create([ 'group_name'       => 'Default group',
						 'short_name'       => 'default',
						 'description'      => 'Barmate default group',
						 'inscription_date' => date('Y-m-d G:i:s') ]);

	}
}
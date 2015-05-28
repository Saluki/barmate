<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;

class GroupTableSeeder extends Seeder {
	
	public function run() {

		Groups::create([ 'group_name'       => 'JH Alleman', 
						'short_name'       => 'alleman',
						'description'      => 'Jeugdhuis Alleman Audergem',
						'inscription_date' => '2014-08-10 12:00:00']);

		Groups::create([ 'group_name'       => "Jeugdhuis 't Mutske", 
						'short_name'       => 'tmuske',
						'description'      => "Jeugdhuis 't Muske Brussel",
						'inscription_date' => '2014-09-23 12:00:00']);

		Groups::create([ 'group_name'       => 'JH de Schakel', 
						'short_name'       => 'schakel',
						'description'      => 'Jeugdhuis de Schakel Woluwe',
						'inscription_date' => '2014-10-05 12:00:00']);
	}
}
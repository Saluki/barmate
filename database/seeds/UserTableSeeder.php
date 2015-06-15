<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\User;

class UserTableSeeder extends Seeder {
	
	public function run() {

		$default = Groups::firstOrFail();

		User::create([  'firstname'        => 'John', 
					 	'lastname'     	   => 'Doe',
						'group_id'         => $default->group_id,
						'email'            => 'admin@barmate.com',
						'password_hash'    => Hash::make('password'),
						'role'             => 'ADMN',
						'inscription_date' => date('Y-m-d G:i:s'),
						'is_active'        => true ]);
	}
}
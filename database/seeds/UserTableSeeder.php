<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\User;

class UserTableSeeder extends Seeder {
	
	public function run() {

		$JH = Groups::where('short_name','=','alleman')->first();
		$jeugdhuisID = $JH->group_id;

		User::create([  'firstname'        => 'John', 
					 	'lastname'     	   => 'Doe',
						'group_id'         => $jeugdhuisID,
						'email'            => 'admin@barmate.com',
						'password_hash'    => Hash::make('password'),
						'role'             => 'ADMN',
						'inscription_date' => '2014-12-05 12:00:00',
						'is_active'        => true ]);

		User::create([  'firstname'        => 'Jack', 
					 	'lastname'     	   => 'Forge',
						'group_id'         => $jeugdhuisID,
						'email'            => 'manager@barmate.com',
						'password_hash'    => Hash::make('password'),
						'role'             => 'MNGR',
						'inscription_date' => '2014-12-05 12:00:00',
						'is_active'        => true ]);

		User::create([  'firstname'        => 'Jeremie', 
					 	'lastname'     	   => 'Badot-Bertrand',
						'group_id'         => $jeugdhuisID,
						'email'            => 'user@barmate.com',
						'password_hash'    => Hash::make('password'),
						'role'             => 'USER',
						'inscription_date' => '2014-12-05 12:00:00',
						'is_active'        => true ]);

	}
}
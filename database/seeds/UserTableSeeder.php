<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder {

	public function run() {

		$default = Groups::firstOrFail();

        User::create([  'firstname'        => 'Nathan',
            'lastname'     	   => 'Ingram',
            'group_id'         => $default->group_id,
            'email'            => 'user@barmate.com',
            'password_hash'    => Hash::make('password'),
            'role'             => 'USER',
            'inscription_date' => Carbon::now()->toDateTimeString(),
            'is_active'        => true ]);

        User::create([  'firstname'        => 'John',
            'lastname'     	   => 'Reese',
            'group_id'         => $default->group_id,
            'email'            => 'manager@barmate.com',
            'password_hash'    => Hash::make('password'),
            'role'             => 'MNGR',
            'inscription_date' => Carbon::now()->toDateTimeString(),
            'is_active'        => true ]);

        User::create([  'firstname'        => 'Harold',
            'lastname'     	   => 'Finch',
            'group_id'         => $default->group_id,
            'email'            => 'administrator@barmate.com',
            'password_hash'    => Hash::make('password'),
            'role'             => 'ADMN',
            'inscription_date' => Carbon::now()->toDateTimeString(),
            'is_active'        => true ]);
	}
}
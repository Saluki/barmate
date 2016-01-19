<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder {

	public function run() {

		$default = Groups::firstOrFail();

        User::create([  'firstname'        => 'administrator',
            'lastname'     	   => 'administrator',
            'group_id'         => $default->group_id,
            'email'            => 'administrator@domain.com',
            'password_hash'    => Hash::make('barmate'),
            'role'             => 'ADMN',
            'inscription_date' => Carbon::now()->toDateTimeString(),
            'is_active'        => true ]);
	}
}
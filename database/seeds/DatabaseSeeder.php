<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use \DB;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();
		
		DB::table('stock_operations')->delete();
		DB::table('sale_details')->delete();
		DB::table('products')->delete();
		DB::table('categories')->delete();
		DB::table('snapshot_details')->delete();
		DB::table('sales')->delete();
		DB::table('cash_snapshots')->delete();

		DB::table('connect_history')->delete();
		DB::table('reset_history')->delete();
		DB::table('users')->delete();

        DB::table('settings')->delete();
		DB::table('groups')->delete();

		$this->command->info('All data truncated');

		$this->call('GroupTableSeeder');
        $this->call('SettingTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('CategoryTableSeeder');
        $this->call('CashSnapshotTableSeeder');

        // Seeding can sometimes cause bugs for already logged users.
        $this->command->info('Please flush the application cache by running cache:clear');
	}

}

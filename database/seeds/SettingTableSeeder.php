<?php

use Illuminate\Database\Seeder;
use App\Models\Groups;
use App\Models\Settings;

class SettingTableSeeder extends Seeder {

    public function run() {

        $default = Groups::firstOrFail();

        Settings::create([  'group_id'      => $default->group_id,
                            'setting_name'  => 'stock_empty_alert',
                            'setting_value' => '10' ]);
    }
}
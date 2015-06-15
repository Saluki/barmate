<?php

use Illuminate\Database\Seeder;
use App\User;
use \App\Models\CashSnapshots;

class CashSnapshotTableSeeder extends Seeder {

    public function run()
    {
        // Get application administrator
        $admin = User::where('role','=','ADMN')->firstOrFail();

        $cashSnapshot = new CashSnapshots();
        $cashSnapshot->snapshot_title = 'Initial snapshot';
        $cashSnapshot->description = 'First snapshot';
        $cashSnapshot->amount = 0;
        $cashSnapshot->time = date('Y-m-d G:i:s');
        $cashSnapshot->user_id = $admin->user_id;
        $cashSnapshot->group_id = $admin->group_id;
        $cashSnapshot->is_closed = false;

        $cashSnapshot->save();
    }

}

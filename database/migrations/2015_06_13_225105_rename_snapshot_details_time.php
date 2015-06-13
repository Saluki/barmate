<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSnapshotDetailsTime extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('snapshot_details', function(Blueprint $table)
        {
            $table->renameColumn('time','timed');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('snapshot_details', function(Blueprint $table)
        {
            $table->renameColumn('timed','time');
        });
	}

}

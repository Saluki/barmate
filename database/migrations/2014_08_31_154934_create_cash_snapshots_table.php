<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashSnapshotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cash_snapshots', function(Blueprint $table)
		{
			$table->increments('cs_id');
			$table->string('snapshot_title', 50);
            $table->text('description');
            $table->decimal('sum', 6, 2);
            $table->timestamp('time');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('group_id');
            
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('group_id')->references('group_id')->on('groups');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cash_snapshots');
	}

}

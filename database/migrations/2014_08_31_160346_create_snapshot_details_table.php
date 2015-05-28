<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnapshotDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('snapshot_details', function(Blueprint $table)
		{
			$table->increments('csd_id');
			$table->char('type', 4);
            $table->decimal('sum', 6, 2);
            $table->timestamp('time');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('sale_id')->nullable();
            $table->unsignedInteger('cs_id');
            $table->text('comment')->nullable();
            
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('sale_id')->references('sale_id')->on('sales');
            $table->foreign('cs_id')->references('cs_id')->on('cash_snapshots');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('snapshot_details');
	}

}

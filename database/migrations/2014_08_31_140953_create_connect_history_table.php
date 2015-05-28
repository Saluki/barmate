<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('connect_history', function(Blueprint $table)
		{
			$table->increments('ch_id');
			$table->unsignedInteger('user_id');
            $table->string('email', 150);
            $table->string('connect_ip', 50);
            $table->timestamp('connect_time');
            
            $table->foreign('user_id')->references('user_id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('connect_history');
	}

}

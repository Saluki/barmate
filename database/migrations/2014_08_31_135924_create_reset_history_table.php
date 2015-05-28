<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResetHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reset_history', function(Blueprint $table)
		{
			$table->increments('rh_id');
            $table->unsignedInteger('user_id');
            $table->string('key', 250);
            $table->string('request_ip', 50);
            $table->string('email', 150);
            $table->timestamp('started_at');
            $table->timestamp('valid_until');
            $table->timestamp('activated_at');
            
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
		Schema::drop('reset_history');
	}

}

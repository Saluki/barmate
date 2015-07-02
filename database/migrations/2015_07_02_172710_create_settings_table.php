<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('setting_id');
            $table->unsignedInteger('group_id');

            $table->string('setting_name', 50);
			$table->text('setting_value');

            $table->timestamps();

            $table->foreign('group_id')->references('group_id')->on('groups');
            $table->unique(['group_id', 'setting_name']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('group_id');
            $table->string('group_name', 50);
            $table->string('short_name', 50);
            $table->text('description')->nullable();
            $table->timestamp('inscription_date');
            $table->boolean('is_active')->default(true);

            $table->unique('group_name');
            $table->unique('short_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groups');
	}

}

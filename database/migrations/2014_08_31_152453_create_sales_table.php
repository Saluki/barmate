<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales', function(Blueprint $table)
		{
			$table->increments('sale_id');
			$table->unsignedInteger('group_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('time');
            $table->decimal('sum', 6, 2);
            $table->decimal('paid', 6, 2);
            $table->boolean('is_active')->default(true);
            
            $table->foreign('group_id')->references('group_id')->on('groups');
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
		Schema::drop('sales');
	}

}

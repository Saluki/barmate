<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sale_details', function(Blueprint $table)
		{
			$table->increments('sd_id');
			$table->unsignedInteger('sale_id');
            $table->unsignedInteger('product_id');
            $table->integer('quantity')->default(0);
            $table->decimal('current_price', 6, 2);
            
            $table->foreign('sale_id')->references('sale_id')->on('sales');
            $table->foreign('product_id')->references('product_id')->on('products');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sale_details');
	}

}

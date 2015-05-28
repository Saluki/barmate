<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('product_id');
            $table->unsignedInteger('category_id');
            $table->string('product_name', 50);
            $table->string('description', 250)->nullable();
            $table->decimal('price', 6, 2);
            $table->integer('quantity');
            $table->boolean('is_active')->default(true);
			$table->timestamps();
            
            $table->foreign('category_id')->references('category_id')->on('categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}

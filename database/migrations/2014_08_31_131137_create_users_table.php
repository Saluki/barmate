<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('user_id');
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->unsignedInteger('group_id');
            $table->string('email', 150);
            $table->string('password_hash', 60);
            $table->enum('role', ['USER','MNGR','ADMN'])->default('USER');
            $table->timestamp('inscription_date');
            $table->string('picture', 250)->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->softDeletes();
            
            $table->foreign('group_id')->references('group_id')->on('groups');
            $table->unique('email');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}

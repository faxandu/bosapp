<?php

use Illuminate\Database\Migrations\Migration;

class UserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function($table){
				$table->increments('id');
				$table->string('name', 30);
				$table->string('email', 50);
				$table->string('password', 128);
				$table->string('username', 30);
				$table->string('first_name', 30);
				$table->string('last_name', 30);


			
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
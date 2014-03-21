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
		Schema::create('global_user', function($table){
			$table->increments('id');

			$table->string('email', 50);
			$table->string('first_name', 30);
			$table->string('last_name', 30);
			$table->string('password', 128);
			$table->enum('type', array('labAide','fullTime','partTime', 'adjunct', 'labTech', 'other'))->default('other');
			$table->string('username', 30);
			
			
			$table->timestamps();
			//$table->enum('department', array('labAide','fullTime','partTime', 'adjunct', 'labTech', 'other'))->default('other');
			
			

			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('global_user');
	}

}
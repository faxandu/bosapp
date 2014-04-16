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

			$table->string('email', 50);
			$table->string('first_name', 30);
			$table->string('last_name', 30);
			$table->string('password', 128);
			$table->enum('department', array('bos', 'none'))->default('none');
			$table->enum('admin', array('bos', 'none'))->default('none');
			$table->enum('type', array('labAide','fullTime','partTime', 'adjunct', 'labTech', 'other'))->default('other');
			$table->string('username', 30);
			
			
			$table->timestamps();
			
		});
		// Schema::table('global_user',  function($table){
		// 			$table->enum('department', array('bos', 'none'))->default('none');
		// 	$table->enum('admin', array('bos', 'none'))->default('none');
		// 	});
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
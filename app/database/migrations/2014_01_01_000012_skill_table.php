<?php

use Illuminate\Database\Migrations\Migration;

class SkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('skill', function($table){
			$table->increments('id');
			$table->string('name', 30)->unique();
			


			// $table->unsignedInteger('second_id');
			// $table->foreign('second_id')->references('skill_id')->on('skill_user');
			
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('skill');
	}

}
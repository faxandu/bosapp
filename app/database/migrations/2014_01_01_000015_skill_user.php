<?php

use Illuminate\Database\Migrations\Migration;

class SkillUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('skill_user', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('skill_id');

			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('skill_id')->references('id')->on('skill');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('skill_user');
	}

}
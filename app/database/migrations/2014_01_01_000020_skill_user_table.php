<?php

use Illuminate\Database\Migrations\Migration;

class SkillUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staffing_app_skill_user', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('skill_id');

			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('skill_id')->references('id')->on('staffing_app_skill');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staffing_app_skill_user');
	}

}
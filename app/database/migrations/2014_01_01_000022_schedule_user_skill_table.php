<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleUserSkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_user_skill', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('skill_id');

			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('skill_id')->references('id')->on('schedule_skill');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_user_skill');
	}

}

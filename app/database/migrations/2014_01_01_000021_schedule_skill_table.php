<?php

use Illuminate\Database\Migrations\Migration;

class ScheduleSkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_skill', function($table){
			$table->increments('id');

			$table->string('name', 100)->unique();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_skill');
	}

}



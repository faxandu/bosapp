<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleCourseLabaideTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_course_labaide', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('course_id');
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('course_id')->references('id')->on('schedule_course');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_course_labaide');
	}

}


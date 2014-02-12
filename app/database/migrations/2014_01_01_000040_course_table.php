<?php

use Illuminate\Database\Migrations\Migration;

class CourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staffing_app_course', function($table){
			$table->increments('id');
			$table->string('name', 30);
			$table->string('daysInWeek', 10);
			$table->string('crn', 10)->unique();
			$table->integer('creditHour')->unsigned();
			$table->date('startDate');
			$table->date('endDate');
			$table->time('startTime');
			$table->time('endTime');

			$table->unsignedInteger('labAide')->nullable();
			$table->unsignedInteger('instructor')->nullable();

			$table->foreign('labAide')->references('id')->on('auth_user');
			$table->foreign('instructor')->references('id')->on('auth_user');
			});
	}


	

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staffing_app_course');
	}

}
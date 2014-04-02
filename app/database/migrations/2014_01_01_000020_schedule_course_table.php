<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleCourseTable extends Migration {


	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_course', function($table){
			$table->increments('id');
			
			$table->integer('creditHour')->unsigned();
			$table->string('crn', 10)->unique();
			$table->string('daysInWeek', 10);
			$table->date('endDate');
			$table->time('endTime');
			$table->string('name', 30);
			$table->date('startDate');
			$table->time('startTime');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_course');
	}

}
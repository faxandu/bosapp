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
		Schema::create('lotto_course', function($table){
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
		Schema::drop('lotto_course');
	}

}
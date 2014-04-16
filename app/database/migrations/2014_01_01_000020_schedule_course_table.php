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

			$table->string('building', 4);
			$table->integer('course_number');
			$table->string('course_title', 100);
<<<<<<< HEAD
			$table->integer('creditHour')->unsigned();
=======
			$table->integer('credit_hours')->unsigned();
>>>>>>> upstream/master
			$table->string('crn', 10)->unique();
			$table->string('days_of_week', 10);
			$table->date('end_date');
			$table->time('end_time');
			$table->string('instructor', 30);
			$table->integer('part_of_term');
			$table->integer('room_number');
			$table->string('section', 10);
			$table->date('start_date');
			$table->time('start_time');
			$table->string('subject_code', 10);
			$table->integer('term_code');
			
			$table->softDeletes();
			$table->timestamps();
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
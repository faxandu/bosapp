<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleAvailabilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_availability', function($table){
			$table->increments('id');
			$table->enum('day_of_week', array('M','Tu','W', 'R', 'F', 'S'));
			$table->time('start_time', 50);
			$table->time('end_time', 50);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_availability');
	}

}

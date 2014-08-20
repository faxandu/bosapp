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

			$table->string('title', 50)->nullable();
			$table->integer('weekday');
			$table->time('start_time', 50);
			$table->time('end_time', 50);
			$table->text('notes')->nullable();

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

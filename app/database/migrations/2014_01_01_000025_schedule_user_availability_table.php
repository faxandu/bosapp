<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleUserAvailabilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_user_availability', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('availability_id');

			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('availability_id')->references('id')->on('schedule_availability');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_user_availability');
	}

}

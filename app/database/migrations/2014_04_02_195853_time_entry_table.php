<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimeEntryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('time_tracking_entry',function($table) {

            $table->increments('id');
            $table->foreign('category')->references('id')->on('time_tracking_categories');
            $table->foreign('user')->references('id')->on('user');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->time('startTime');
            $table->time('endTime')->nullable();
            $table->text('description')->nullable();
            $table->boolean('clocked_in')->defalut(false);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

	public function down()
	{
		Schema::drop('time_entry_table');
	}

}

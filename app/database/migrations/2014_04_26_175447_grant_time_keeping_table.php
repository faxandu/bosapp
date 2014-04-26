<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GrantTimeKeepingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grant_time_tracking',function($table) {

            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('pay_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('grant_time_tracking_categories');
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('pay_id')->references('id')->on('grant_time_tracking_pay_period')
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

		Schema::drop('grant_time_tracking');

	}

}

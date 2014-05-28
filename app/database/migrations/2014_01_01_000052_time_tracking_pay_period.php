<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimeTrackingPayPeriod extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('time_tracking_pay_period',function($table){

            $table->increments('id');
            $table->date('start_pay_period');
            $table->date('end_pay_period');
        });
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

        Schema::drop('time_tracking_pay_period');
			//
	}

}

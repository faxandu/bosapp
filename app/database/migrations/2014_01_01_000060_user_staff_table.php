<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserStaffTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staffing_app_user_staff', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('staff_id');
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('staff_id')->references('id')->on('staffing_app_staffType');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staffing_app_user_staff');
	}

}

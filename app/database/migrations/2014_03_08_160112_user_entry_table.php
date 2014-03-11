<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserEntryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staffing_app_user_entries', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('entry_id');
			$table->foreign('user_id')->references('id')->on('auth_user');
			$table->foreign('entry_id')->references('id')->on('staffing_app_entries');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staffing_app_user_entries');
	}

}

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
		Schema::create('lotto_user_entries', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('entry_id');
			$table->foreign('user_id')->references('id')->on('global_user');
			$table->foreign('entry_id')->references('id')->on('lotto_entries');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lotto_user_entries');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lotto_entries', function($table) {
			$table->increments('id');
			$table->date('startDate')->nullable();
			$table->date('endDate')->nullable();
			$table->time('startTime')->nullable();
			$table->time('endTime')->nullable();
			$table->string('title', 40);
			$table->text('description')->nullable();
			$table->enum('type', array('availability','preference','other'))->default('other');
			
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
		//
		Schema::drop('lotto_entries');
	}

}

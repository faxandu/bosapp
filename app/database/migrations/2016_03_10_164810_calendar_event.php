<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CalendarEvent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('title', 40);
			$table->dateTime('start_date');
			$table->dateTime('end_date');
			$table->string('description')->nullable();
			$table->string('last_updated_by', 40);
			$table->string('created_by', 40);
			$table->string('created_for', 40);
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
		Schema::drop('events');
	}

}
/*

CREATE TABLE events(
	id int(6) unsigned AUTO_INCREMENT PRIMARY KEY,
	title varchar(40) NOT NULL,
	start_date datetime NOT NULL,
	end_date datetime NOT NULL,
	description tinytext,
	last_updated_by varchar(40) NOT NULL,
	created_by varchar(40) NOT NULL,
	created_for varchar(40) NOT NULL
);
*/
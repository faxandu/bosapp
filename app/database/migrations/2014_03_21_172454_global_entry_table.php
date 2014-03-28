<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GlobalEntryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('global_entry', function($table){
			$table->increments('id');

			$table->time('start_time');
			$table->time('end_time');
			$table->date('start_date');
			$table->date('end_date');


			$table->string('title', 30)->nullable();
			//$table->text('description')->nullable();
			//$table->boolean('clocked_in')->nullable();
			
			//$table->timestamps();			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('global_entry');
	}

}

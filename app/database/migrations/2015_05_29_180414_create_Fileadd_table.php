<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileaddTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_fileadd', function($table)
		{
			$table->increments('id');
			$table->integer('equipment_id') -> unsigned();
			$table->string('path');
			$table->string('notes')->nullable();
			$table->foreign('equipment_id')->references('id')->on('inventory_equipment');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inventory_fileadd');
	}

}

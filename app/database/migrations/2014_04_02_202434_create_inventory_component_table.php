<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryComponentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_component', function($table){
			$table->increments('id');
			$table->integer('equipment_id') -> unsigned() -> nullable();
			$table->string('location') -> nullable();
			$table->string('model');
			$table->string('type');
			$table->string('storage')->nullable();
			$table->string('memory')->nullable();
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
		Schema::drop('inventory_component');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryEquipmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_equipment', function($table){
			$table->integer('id')->unsigned();
			$table->string('manufacturer');
			$table->string('model') -> nullable();
			$table->string('location');
			$table->date('obtained')->nullable();
			$table->date('warranty')->nullable();
			$table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inventory_equipment');
	}

}

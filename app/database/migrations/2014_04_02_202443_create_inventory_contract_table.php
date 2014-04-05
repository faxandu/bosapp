<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryContractTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_contract', function($table){
			$table->increments('id');
			$table->integer('equipment_id') -> unsigned();
			$table->string('type');
			$table->date('expiration');
			$table->string('contract_number');
			$table->string('vendor');
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
		Schema::drop('inventory_contract');
	}

}

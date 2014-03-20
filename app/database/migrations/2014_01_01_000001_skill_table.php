<?php

use Illuminate\Database\Migrations\Migration;

class SkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lotto_skill', function($table){
			$table->increments('id');
			$table->string('name', 30)->unique();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lotto_skill');
	}

}
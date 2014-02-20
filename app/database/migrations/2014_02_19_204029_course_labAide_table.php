<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourseLabAideTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staffing_app_course_labAide', function($table){
			$table->unsignedInteger('user_id');
			$table->unsignedInteger('course_id');
			$table->foreign('user_id')->references('id')->on('auth_user');
			$table->foreign('course_id')->references('id')->on('staffing_app_course');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staffing_app_course_labAide');
	}

}

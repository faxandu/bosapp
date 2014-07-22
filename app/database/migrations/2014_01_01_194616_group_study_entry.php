<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupStudyEntry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("group_study_entry", function($table){
			$table->increments('id');
			$table->unsignedInteger('student_id');
			$table->string('class');
			$table->date('date');
			$table->time('start_time')->nullable();
			$table->time('end_time')->nullable();
			$table->string('facilitator')->nullable();
			$table->foreign('student_id')->references('id')->on('group_study_student');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_study_entry');
	}

}

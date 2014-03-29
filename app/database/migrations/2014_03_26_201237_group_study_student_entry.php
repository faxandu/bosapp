<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroupStudyStudentEntry extends Migration {

		/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_study_student_entry', function($table){
			$table->unsignedInteger('student_id');
			$table->unsignedInteger('entry_id');
			$table->foreign('student_id')->references('id')->on('group_study_student');
			$table->foreign('entry_id')->references('id')->on('global_entry');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_study_student_entry');
	}


}

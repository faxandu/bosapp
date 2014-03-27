<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('time_categories_table', function($table){
            $table->increments('id');
            $table->enum('choices',array('LAB_AIDE','OTHER','FACILITATOR','MEETING',
                'GRANT' ,'GROUP_STUDY', 'COURSE_LOTTO', 'PROJECT_MANAGEMENT','INVENTORY_MANAGEMENT',
                'TIME_KEEPING' ) );
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
	}

}

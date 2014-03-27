<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntryCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entry_category_table', function($table){
            $table->unsignedInteger('categories_id');
            $table->unsignedInteger('entry_id');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('entry_id')->references('id')->on('entry');


        });
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

    public function down()
	{
        Schema::drop('entry_category_table');
	}

}

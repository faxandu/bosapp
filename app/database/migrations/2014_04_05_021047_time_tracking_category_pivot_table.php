<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimeTrackingCategoryPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
    {
        Schema::create('time_tracking_category_pivot' ,function($table){
        $table->unsignedInteger('time_id');
        $table->unsignedInteger('category_id');
        $table->foreign('time_id')->references('id')->on('time_tracking_entry');
        $table->foreign('category_id')->references('id')->on('time_tracking_categories');
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('time_tracking_category_pivot');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTimeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	     Schema::create('user_time',function($table){

             $table->unsignedInteger('user_id');
             $table->unsignedInteger('time_id');
             $table->foreign('user_id')->references('id')->on('user');
             $table->foreign('time_id')->references('id')->on('time_tracking_entry');
         });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

<<<<<<< HEAD

        Schema::drop('user_time');


=======
        Schema::drop('user_time');

>>>>>>> upstream/master
	}

}

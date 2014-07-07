<?php

namespace GroupStudy\models;
use Input, User, Response, Eloquent;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Entry extends Eloquent{

	protected $table = 'group_study_student';
	protected $fillable = array('student_id', 'class', 'start_time', 'end_time', 'facilitator');
	protected $guarded = array('id');
	public $timestamps = false;

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */

	public function student(){
		return $this -> belongsTo('Student');
	}


}

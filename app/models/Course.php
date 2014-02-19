<?php


class Course extends Eloquent {

	protected $table = 'staffing_app_course';
	public $timestamps = false;
	protected $fillable = array('name', 'crn', 'creditHour', 'daysInWeek', 'startDate',
	 'endDate', 'endTime', 'startTime', 'labAide', 'instructor');
	protected $guarded = array('id');


	private static $rules = array(
			'creditHour' => 'required|numeric',
			'crn' => 'required|alpha_num',
			'daysInWeek' => 'alpha',
			
			//note can check format date
			'endDate' => 'date',
			'endTime' => 'time',
			'name' => 'required|alpha_num',
			'startDate' => 'date',
			'startTime' => 'time',
			'labAide' => 'numeric',
			'instructor' => 'numeric'
		);

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}

	public static function boot(){
        parent::boot();

        Course::created(function($course){
           	try{
        		$skill = Skill::where('name' ,'=' , $course->name)->firstOrFail();
        	}catch (Exception $e){
        		Skill::create(array('name' => $course->name));
        	}
        	//Skill::create(array('name' => $course->name));
        });

    }

	public function labAide(){
		return $this->hasOne('labAide');
	}

	public function instructor(){
		return $this->hasOne('instructor');
	}
}
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
			//'endTime' => 'time',
			//'name' => 'required|alpha_num',
			'startDate' => 'date',
			'startTime' => 'time',
			//'labAide' => 'numeric|exists:auth_user,id',
			//'instructor' => 'numeric|exists:auth_user,id'
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

	// public function labAide(){
	// 	return $this->hasOne('labAide');
	// }

	// public function instructor(){
	// 	return $this->hasOne('instructor');
	// }

	public function labAide(){
        return $this->belongsToMany('User', 'staffing_app_course_labAide');
    }

     public function labAideArr(){
    	$pivot = $this->belongsToMany('User', 'staffing_app_course_labAide')->getResults();
    	$users = array();
    	foreach($pivot as $user){
    		array_push($users, $user->attributes);
    	}
    	return $users;
    }
    

    protected static function checkSkills($user, $course){
    	foreach ($user->skillsArr() as $skill){
    		if ($skill['name'] == $course->name)
    			return true;
    	}

    	throw new Exception("Missing required skill");
    }

    private static $labAide = 20;
    private $labTech = 20;

    protected static function checkTime($user, $course){
    	
        $time = $course->creditHour;

    	foreach ($user->labAideArr() as $anotherCourse){
    		$time += $anotherCourse['creditHour'];
    	}


    	
    	foreach ($user->staffTypeArr() as $type){
           
    		switch($type['type']){

    			case 'labAide': if($time < Course::$labAide) return true;
    		}

    	}

		throw new Exception("Insufficient time.");
    }

	public static function checkUser($user, $course){
		course::checkSkills($user, $course);		
		course::checkTime($user, $course);
		
		return true;
	}




}
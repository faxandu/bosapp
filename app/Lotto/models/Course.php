<?php 

namespace Lotto\models;

use Eloquent, Validator, Exception;



class Course extends Eloquent {

	protected $table = 'schedule_course';
	public $timestamps = true;
    protected $softDelete = false;


	protected $fillable = array('building', 'course_number', 'course_title', 'credit_hours', 'crn',
	 'days_of_week', 'end_date', 'end_time', 'instructor', 'status_code', 'part_of_term','room_number',
      'section', 'start_date', 'start_time', 'subject_code', 'term_code');
	

    protected $guarded = array('id');
    protected $hidden = array('pivot');

	private static $rules = array(
		'creditHour' => 'required|numeric',
		'crn' => 'required|alpha_num',
		'daysInWeek' => 'alpha',
		'endDate' => 'date',
		//'endTime' => 'time',
		//'name' => 'required|alpha_num',
		'startDate' => 'date',
		'startTime' => 'time',
		//'labAide' => 'numeric|exists:auth_user,id',
		//'instructor' => 'numeric|exists:auth_user,id'
	);

    private static $updateRules = array(
        'id' => 'required|numeric|exists:lotto_course,id',
        'creditHour' => 'numeric',
        'crn' => 'alpha_num',
        'daysInWeek' => 'alpha',
        'endDate' => 'date',
        //'endTime' => 'time',
        //'name' => 'required|alpha_num',
        'startDate' => 'date',
        'startTime' => 'time',
        'labAide' => 'numeric|exists:global_user,id'
    );

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}

    public static function updateValidate($data){
        return Validator::make($data, static::$updateRules);
    }

	public static function boot(){
        parent::boot();

        Course::created(function($course){
           	try{
        		Skill::where('name' ,'=' , $course->course_title)->firstOrFail();
        	}catch (Exception $e){
        		Skill::create(array('name' => $course->course_title));
        	}

        });

        Course::creating(function($course){
            
        });

        Course::updating(function($course){
            ////// UPDATING COURSE - NOTIFY USER?
        });
        Course::deleting(function($course){
            echo "deleting";
            $course->labaides()->detach();
           ///// DELETING COURSE - NOTIFY USER?
        });

    }


	public function labaides(){
        return $this->belongsToMany('User', 'schedule_course_labaide');
    }

    protected static function checkSkills($user, $course){
       

        if(in_array($course->course_title, $user->skills->fetch('name')->toarray()))

            return true;

    	throw new Exception("Missing required skill");
    }

    private static $labAide = 20;
    private $labTech = 20;

    protected static function checkTime($user, $course){
    	
        $time = $course->creditHour;

        if(!empty($user->courses->toarray())){
        	foreach ($user->courses as $anotherCourse){
        		$time += $anotherCourse['creditHour'];
        	}
        }
           
		switch($user->type){

			case 'labAide': if($time < Course::$labAide) return true;
		}


		throw new Exception("Insufficient time.");
    }

	public static function checkUser($user, $course){

        if(!('labAide' == $user->type))
            throw new Exception("Invalid employee type");
		course::checkSkills($user, $course);		
		course::checkTime($user, $course);
		
		return true;
	}

}


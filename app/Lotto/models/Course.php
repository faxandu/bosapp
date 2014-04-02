<?php 

namespace Lotto\models;
use Eloquent, Validator;



class Course extends Eloquent {

	protected $table = 'schedule_course';
	public $timestamps = false;
	protected $fillable = array('name', 'crn', 'creditHour', 'daysInWeek', 'startDate',
	 'endDate', 'endTime', 'startTime', 'labAide', 'instructor');
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
        		$skill = Skill::where('name' ,'=' , $course->name)->firstOrFail();
        	}catch (Exception $e){
        		Skill::create(array('name' => $course->name));
        	}
        });

        Course::creating(function($course){
            
        });

        Course::deleting(function($course){
           
        });

    }

	public function labAides(){
        return $this->belongsToMany('User', 'lotto_course_labAide');
    }

    protected static function checkSkills($user, $course){
       
        if(in_array($course->name, $user->skills->fetch('name')->toarray()))
            return true;

    	throw new Exception("Missing required skill");
    }

    private static $labAide = 20;
    private $labTech = 20;

    protected static function checkTime($user, $course){
    	
        $time = $course->creditHour;

    	foreach ($user->courses as $anotherCourse){
    		$time += $anotherCourse['creditHour'];
    	}


    	
    	foreach ($user->staffTypes as $type){
           
    		switch($type['type']){

    			case 'labAide': if($time < Course::$labAide) return true;
    		}

    	}

		throw new Exception("Insufficient time.");
    }

	public static function checkUser($user, $course){

        if(! in_array( 'labAide', $user->staffTypes->fetch('type')->toarray() ) )
            throw new Exception("Invalid employee type");
		course::checkSkills($user, $course);		
		course::checkTime($user, $course);
		
		return true;
	}

}


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



	public static function validate($data){
		return Validator::make($data, static::$rules);
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

        Course::updated(function($course){
            echo "h";
            exit;
        });


        Course::deleting(function($course){

            $course->labaides()->detach();
           ///// DELETING COURSE - NOTIFY USER?
        });

        Course::deleted(function($course){



            // Delete skill when no courses left?
            // currently failing because of skill linked to user on delete
            // try{

            //     $count = Course::where('course_title' ,'=' , $course->course_title)->count();

            //     if($count == 0){
            //         $skill = Skill::where('name' ,'=' , $course->course_title)->firstOrFail();
                    
            //         print_r($skill);
            //         exit;

            //         $skill->delete();
            //     }
            
            // }catch (Exception $e){
            
            //     // do nothing on fail
            
            // }
        });

    }


	public function labaides(){
        return $this->belongsToMany('User', 'schedule_course_labaide');
    }

    public function setLabaide($user){
        $this->labaides()->sync(array($user->id));
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


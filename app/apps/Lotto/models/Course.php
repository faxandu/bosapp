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



        });

        Course::updated(function($course){

        });


        Course::deleting(function($course){

            $course->labaides()->detach();
           ///// DELETING COURSE - NOTIFY USER?
        });

        Course::deleted(function($course){

        });

    }


    public function assignLabaide($user){

        $user->syncWorkingHours();
        $user->updateAvailability($this);
        $this->labaides()->detach();
        $this->labaides()->attach($user->id);

    }


	public function labaides(){
        return $this->belongsToMany('User', 'schedule_course_labaide');
    }

    public function setLabaide($user){
        $this->labaides()->sync(array($user->id));
    }


}


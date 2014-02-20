<?php

class User extends Eloquent {

	protected $table = 'auth_user';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_superuser', 'is_staff', 'is_active', 'date_joined');
	
    private static $rules = array(
        'id' => 'numeric|exists:auth_user,id'
    );

    public static function validate($data){
        return Validator::make($data, static::$rules);
    }

    public function skills(){
        return $this->belongsToMany('Skill', 'staffing_app_skill_user');
    }


    public function skillsArr(){
    	$pivot = $this->belongsToMany('Skill', 'staffing_app_skill_user')->getResults();
    	$skills = array();
        
    	foreach($pivot as $skill){
    		array_push($skills, $skill->attributes);
    	}
    	return $skills;
    }

    public function labAide(){
        return $this->belongsToMany('Course', 'staffing_app_course_labAide');
    }

     public function labAideArr(){
        $pivot = $this->belongsToMany('Course', 'staffing_app_course_labAide')->getResults();
        $courses = array();
        foreach($pivot as $course){
            array_push($courses, $course->attributes);
        }
        return $courses;
    }

    public function staffType(){
        return $this->belongsToMany('StaffType', 'staffing_app_user_staff', 'user_id', 'staff_id');
    }

     public function staffTypeArr(){

        $pivot = $this->belongsToMany('StaffType', 'staffing_app_user_staff', 'user_id', 'staff_id')->getResults();
        $types = array();

        foreach($pivot as $staff){
            array_push($types, $staff->attributes);
        }
        return $types;
    }
}
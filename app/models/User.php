<?php

class User extends Eloquent {

	protected $table = 'auth_user';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_superuser', 'is_staff', 'is_active', 'date_joined');
	

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


    public function staffType(){
        return $this->belongsToMany('Staff', 'staffing_app_staffType');
    }

     public function staffTypeArr(){
        $pivot = $this->belongsToMany('Staff', 'staffing_app_staffType')->getResults();
        $types = array();
        foreach($pivot as $staff){
            array_push($types, $staff->attributes);
        }
        return $types;
    }
}
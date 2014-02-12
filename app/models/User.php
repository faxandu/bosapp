<?php


class User extends Eloquent {



	protected $table = 'auth_user';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');

	public function skills()
    {
    	
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



}
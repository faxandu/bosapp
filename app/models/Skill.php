<?php


class Skill extends Eloquent {

	protected $table = 'staffing_app_skill';
	public $timestamps = false;
	protected $fillable = array('name');

	protected $guarded = array('id');


	public function users(){
        return $this->belongsToMany('User', 'staffing_app_skill_user');
    }

     public function usersArr(){
    	$pivot = $this->belongsToMany('User', 'staffing_app_skill_user')->getResults();
    	$users = array();
    	foreach($pivot as $user){
    		array_push($users, $user->attributes);
    	}
    	return $users;
    }

}
<?php


class Skill extends Eloquent {

	protected $table = 'skill';
	public $timestamps = false;
	protected $fillable = array('name');

	protected $guarded = array('id');


	public function users(){
        return $this->belongsToMany('User', 'skill_user');
    }

     public function usersArr(){
    	$pivot = $this->belongsToMany('User', 'skill_user')->getResults();
    	$users = array();
    	foreach($pivot as $user){
    		array_push($users, $user->attributes);
    	}
    	return $users;
    }

}
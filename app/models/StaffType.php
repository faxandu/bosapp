<?php


class StaffType extends Eloquent {

	protected $table = 'staffing_app_staffType';
	public $timestamps = false;
	protected $fillable = array('type');
	protected $guarded = array('id');

	public function user(){
        return $this->belongsToMany('User', 'staffing_app_user_staff');
    }

     public function userArr(){
    	$pivot = $this->belongsToMany('User', 'staffing_app_user_staff')->getResults();
    	$users = array();
    	foreach($pivot as $user){
    		array_push($users, $user->attributes);
    	}
    	return $users;
    }
}
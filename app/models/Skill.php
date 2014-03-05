<?php


class Skill extends Eloquent {

	protected $table = 'staffing_app_skill';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('pivot');

	public function users(){
        return $this->belongsToMany('User', 'staffing_app_skill_user');
    }

}
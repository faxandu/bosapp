<?php
namespace Lotto\models;


use Eloquent, Validator;
use Auth;
use Exception;

class Skill extends Eloquent {

	protected $table = 'schedule_skill';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('pivot');

	public function users(){
        return $this->belongsToMany('User', 'schedule_user_skill');
    }

}


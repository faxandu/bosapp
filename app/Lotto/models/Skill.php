<?php
namespace Lotto\models;
use BaseController;

class Skill extends BaseController {

	protected $table = 'lotto_skill';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('pivot');

	public function users(){
        return $this->belongsToMany('User', 'lotto_skill_user');
    }

}
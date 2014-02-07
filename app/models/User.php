<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');

	public function skills()
    {
    	
        return $this->belongsToMany('Skill', 'skill_user');
    }

    public function skillsArr(){
    	$pivot = $this->belongsToMany('Skill', 'skill_user')->getResults();
    	$skills = array();
    	foreach($pivot as $skill){
    		array_push($skills, $skill->attributes);
    	}
    	return $skills;
    }

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	*
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
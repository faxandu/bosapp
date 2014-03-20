<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


class User extends Eloquent  implements UserInterface, RemindableInterface {

	protected $table = 'global_user';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_superuser', 'is_staff', 'is_active', 'date_joined', 'pivot');
	
    private static $rules = array(
        'id' => 'numeric|exists:user,id'
    );

    public static function validate($data){
        return Validator::make($data, static::$rules);
    }

    public function skills(){
        return $this->belongsToMany('Skill', 'lotto_skill_user');
    }

    public function courses(){
        return $this->belongsToMany('Course', 'lotto_course_labAide');
    }

    // public function staffTypes(){
    //     return $this->belongsToMany('StaffType', 'lotto_user_staff', 'user_id', 'staff_id');
    // }

    public function entries(){
        return $this->belongsToMany('Entry', 'lotto_user_entries', 'user_id', 'entry_id');
    }



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
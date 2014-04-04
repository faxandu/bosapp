<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent  implements UserInterface, RemindableInterface {

	protected $table = 'user';
	public $timestamps = false;
	protected $fillable = array('username','email','first_name','last_name','type','password');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_superuser', 'is_staff', 'is_active', 'date_joined', 'pivot');
	
    private static $rules = array(
        'id' => 'numeric|exists:user,id',
        'username' => 'required|alpha|min:4',
        'email' => 'required|email|unique:users',
    );

    private static $rulesForLogin = array(
        'username' => 'alpha_num|exists:user,username',
        //'password'=>'required|alpha_num|between:6,12|confirmed',
    );

    public static function validate($data){
        return Validator::make($data, static::$rules);
    }

    public static function validateLogin($data){
        return Validator::make($data, static::$rulesForLogin);
    }

    public function skills(){
        return $this->belongsToMany('Skill', 'schedule_user_skill');
    }

    public function courses(){
        return $this->belongsToMany('Course', 'schedule_course_labaide');
    }

    // public function entries(){
    //     return $this->belongsToMany('Entry', 'lotto_user_entries', 'user_id', 'entry_id');
    // }



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

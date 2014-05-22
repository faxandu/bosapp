<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


use Lotto\models\Course, Lotto\models\Skill, Lotto\models\Availability;

class User extends Eloquent  implements UserInterface, RemindableInterface {

	protected $table = 'user';
	public $timestamps = false;
	protected $fillable = array('username', 'admin', 'email','first_name','last_name','type','password',
     'prefered_hours', 'working_hours', 'department');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_active', 'remember_token', 'date_joined', 'pivot');
	
    private static $rules = array(
       // 'id' => 'numeric|exists:user,id',
        'username' => 'required|alpha|min:4',
        'email' => 'required|email|unique:users',
    );

    private static $rulesForLogin = array(
        'username' => 'alpha_num|exists:user,username',
        //'password'=>'required|alpha_num|between:6,12|confirmed',
    );


    public static function boot(){
        parent::boot();

        User::created(function($user){

        });

        User::creating(function($user){
            
        });

        User::updating(function($user){
            ////// UPDATING COURSE - NOTIFY USER?
        });
        User::deleting(function($user){
            $user->skills()->detach();
            $user->courses()->detach();
            $user->availability()->detach();
        });

    }



    public static function validate($data){
        return Validator::make($data, static::$rules);
    }

    public static function validateLogin($data){
        return Validator::make($data, static::$rulesForLogin);
    }

    public function skills(){

        return $this->belongsToMany('Lotto\models\Skill', 'schedule_user_skill');
    }

    public function courses(){
        return $this->belongsToMany('Lotto\models\Course', 'schedule_course_labaide');
    }

    public function availability(){
        return $this->belongsToMany('Lotto\models\Availability', 'schedule_user_availability', 'user_id', 'availability_id');
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
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
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

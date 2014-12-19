<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


use Lotto\models\Course, Lotto\models\Skill, Lotto\models\Availability;

class User extends Eloquent  implements UserInterface, RemindableInterface {

	protected $table = 'user';
	public $timestamps = false;
	protected $fillable = array('username', 'admin', 'email','first_name','last_name','type','password',
     'prefered_hours', 'working_hours', 'department', 'reset_token');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_active', 'remember_token', 'date_joined', 'pivot');
	
    private static $rules = array(
       // 'id' => 'numeric|exists:user,id',
        // 'username' => 'required|alpha|min:4',
        // 'email' => 'required|email|unique:users',
    );



    public static function boot(){
        parent::boot();

        User::created(function($user){

        });

        User::creating(function($user){
            
        });

        User::updating(function($user){
        
        });


        User::updated(function($user){
           
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



    /*  Custom Functions

    ---------------------- */

    public function syncWorkingHours(){

        $courses = $this->courses;

        foreach($courses as $course)
            $this->working_hours += $course->credit_hours;

        $this->save();
    }
        

    public function updateAvailability($course){

        if($this->AvailableToLabaide($course)->get()){

            $availabilities = $this->availability->filter(function($availability) use($course){

                    return (stristr($course->days_of_week, $availability->day_of_week) &&
                    $course->start_time >= $availability->start_time && 
                    $course->end_time <= $availability->end_time) ? $availability : "" ;

            });


            foreach ($availabilities as $a){

        
                $avail1 = Availability::create(array(
                    'start_time' => $a->start_time,
                    'end_time' => $course->start_time,
                    'day_of_week' => $a->day_of_week
                )); 

                $avail2 = Availability::create(array(
                    'start_time' => $course->end_time,
                    'end_time' => $a->end_time,
                    'day_of_week' => $a->day_of_week
                ));

               

                $this->availability()->attach($avail1);
                $this->availability()->attach($avail2);

                 $a->delete();

           }

          

        }

    }



    public function getFullNameWithUsername(){
        return $this->first_name . " " . $this->last_name . " (" . $this->username . ")";
    }

    // MAX HOURS
    private static $labAide = 20;
    private $labTech = 20;


    // To labaide, skills, employee type, and time are required.
    public function checkEligibilityToLabaide($course){

        if($this->type != 'labAide')
            throw new Exception("Invalid employee type");

        if(!$this->hasSkill($course)->get())
            throw new Exception("Missing required skill");

        if(!$this->AvailableToLabaide($course)->get())
            throw new Exception("Insufficient time.");


        return true;
    }



    /*  Relationships

    ---------------------- */
    public function skills(){
        return $this->belongsToMany('Lotto\models\Skill', 'schedule_user_skill');
    }

    public function courses(){
        return $this->belongsToMany('Lotto\models\Course', 'schedule_course_labaide');
    }

    public function availability(){
        return $this->belongsToMany('Lotto\models\Availability', 'schedule_user_availability', 'user_id', 'availability_id');
    }



    /*  Scopes

    ---------------------- */

    public function scopeLabaides($query){

        return $query->where('type','=','labAide');


    }

    public function scopeHasSkill($query, Lotto\models\Course $course){

        return $query->whereHas('skills', function($query) use ($course){
                return $query->where('name', '=', $course->course_title);
            });
    }

    
    public function scopeAvailableToLabaide($query, Lotto\models\Course $course){


        $days = str_split($course->days_of_week);
        
        foreach($days as $day)
            $query->wherehas('availability', function($query) use($day, $course){
                $query->where('day_of_week', 'LIKE', $day)
                    ->where('start_time', '<=', $course->start_time)
                    ->where('end_time', '>=', $course->end_time);
            });

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

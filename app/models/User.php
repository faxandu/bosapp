<?php

class User extends Eloquent {

	protected $table = 'auth_user';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $guarded = array('id');
    protected $hidden = array('password', 'is_superuser', 'is_staff', 'is_active', 'date_joined', 'pivot');
	
    private static $rules = array(
        'id' => 'numeric|exists:auth_user,id'
    );

    public static function validate($data){
        return Validator::make($data, static::$rules);
    }

    public function skills(){
        return $this->belongsToMany('Skill', 'staffing_app_skill_user');
    }

    public function courses(){
        return $this->belongsToMany('Course', 'staffing_app_course_labAide');
    }

    public function staffTypes(){
        return $this->belongsToMany('StaffType', 'staffing_app_user_staff', 'user_id', 'staff_id');
    }
}
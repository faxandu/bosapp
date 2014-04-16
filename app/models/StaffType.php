<?php


class StaffType extends Eloquent {

	protected $table = 'staffing_app_staffType';
	public $timestamps = false;
	protected $fillable = array('type');
	protected $guarded = array('id');
    protected $hidden = array('pivot');
    

    private static $rules = array(
        'type' => 'required|alpha',
    );

    public static function validate($data){
        return Validator::make($data, static::$rules);
    }


	public function users(){
        return $this->belongsToMany('User', 'staffing_app_user_staff', 'staff_id');
    }
}
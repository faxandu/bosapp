<?php 
namespace Lotto\models;

use Eloquent, Validator;
use Auth;
use Exception;
use User;


class Availability extends Eloquent {

    protected $table = 'schedule_availability';
	public $timestamps = false;
    protected $softDelete = false;


	protected $fillable = array('end_time', 'start_time', 'day_of_week', 'user_id');


    protected $guarded = array('id');
    protected $hidden = array('pivot');



    private static $rules = array(
		//'end_date' => 'required|date_format:m/d/y'
	);

    /*
        uses the above rules to validate $data
    */
    public static function validate($data){
        return Validator::make($data, static::$rules);
    }

    public static function boot(){
        parent::boot();

    }


        /*  Scopes

    ---------------------- */
    
    public function scopeGetAvailabilityForCourse($query, Lotto\models\Course $course){


        $days = str_split($course->days_of_week);
        
        foreach($days as $day)
            $query->where(function($query) use($day, $course){
                $query->where('day_of_week', 'LIKE', $day)
                    ->where('start_time', '<=', $course->start_time)
                    ->where('end_time', '>=', $course->end_time);
            });

    }

      /*  Relationships

    ---------------------- */

    public function user(){
        return $this->belongsTo('User');
    }
	

}


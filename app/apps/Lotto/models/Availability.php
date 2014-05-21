<?php 
namespace Lotto\models;

use Eloquent, Validator, Exception;



class Availability extends Eloquent {

	protected $table = 'schedule_availability';
	public $timestamps = false;
    protected $softDelete = false;

	protected $fillable = array('end_date', 'end_time', 'start_date', 'start_time', 'notes', 'title');

    protected $guarded = array('id');
    protected $hidden = array('pivot');

    private static $rules = array(
		//'end_date' => 'required|date_format:m/d/y'
	);

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}

}


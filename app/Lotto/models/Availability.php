<?php 
namespace Lotto\models;

use Eloquent, Validaton, Exception;



class Availability extends Eloquent {

	protected $table = 'schedule_availability';
	public $timestamps = false;
    protected $softDelete = false;

	protected $fillable = array('end_date', 'end_time', 'start_date', 'start_time', 'notes', 'title');

    protected $guarded = array('id');
    protected $hidden = array('pivot');

}


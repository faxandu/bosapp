<?php 

namespace Lotto\models;
use BaseController;

class Entry extends BaseController {

	protected $table = 'lotto_entries';
	public $timestamps = true;
	// protected $fillable = array('name', 'crn', 'creditHour', 'daysInWeek', 'startDate',
	//  'endDate', 'endTime', 'startTime', 'labAide', 'instructor');
	protected $guarded = array('id');
    protected $hidden = array('pivot','created_at', 'updated_at');

}


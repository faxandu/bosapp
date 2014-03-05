<?php

class Entry extends Eloquent {

	protected $table = 'staffing_app_entries';
	public $timestamps = true;
	// protected $fillable = array('name', 'crn', 'creditHour', 'daysInWeek', 'startDate',
	//  'endDate', 'endTime', 'startTime', 'labAide', 'instructor');
	protected $guarded = array('id');
    protected $hidden = array('pivot');

}
<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/5/14
 * Time: 12:57 PM
 */

namespace TimeTracking\models;


class TimeTrackingEntry {

    private $table = 'time_tracking_entry';
    private $fillable = array('start_time','end_time','start_date'
                             ,'end_date','description','clocked_in','category','user');
    private $guarded = 'id';
    private $timestamps = false;

    public function entry(){
        return $this->belongsTo('user');
    }

} 
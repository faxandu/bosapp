<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/5/14
 * Time: 12:57 PM
 */

namespace TimeTracking\models;
use Eloquent, Validaton, Exception;

class TimeTrackingEntry extends Eloquent{

    protected $table = 'time_tracking_entry';
    protected $fillable = array('start_time','end_time','start_date'
                             ,'end_date','description','clocked_in','category'
                             ,'user_id','category_id','pay_id');
    protected $guarded = 'id';
    public $timestamps = false;

    public function entry(){
        return $this->belongsTo('user');
    }

    public function scopeUser($query) {
    	return $query->where('user_id', \Auth::user()->id);
    }

    public function scopePeriod($query, $pay_id) {
    	return $query->where('pay_id', $pay_id);
    }

} 
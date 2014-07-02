<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/5/14
 * Time: 12:57 PM
 */

namespace GrantTimeTracking\models;
use Eloquent, Validaton, Exception;

class GrantTimeTrackingEntry extends Eloquent{

    private $table = 'grant_time_tracking_entry';
    private $fillable = array('start_time','end_time','start_date'
                             ,'end_date','description','clocked_in','category'
                             ,'user_id','category_id','pay_id');
    private $guarded = 'id';
    private $timestamps = false;

    public function entry(){
        return $this->belongsTo('user');
    }

} 
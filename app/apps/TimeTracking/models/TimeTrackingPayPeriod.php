<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 10:20 PM
 */

namespace TimeTracking\models;
use Eloquent, Validator, Exception;

class TimeTrackingPayPeriod extends Eloquent{

    protected $table = 'time_tracking_pay_period';
    protected $guarded = 'id';
    protected $fillable = array('start_pay_period','end_pay_period');
    public $timestamps = false;

    
    public function getPeriod(){
        return $this->select(array('start_pay_period','end_pay_period'));
    }

    private static $rules = array(

    	'start_pay_period' => 'unique:start_pay_period',
    	'end_pay_period'   => 'unique:end_pay_period' ,
    	'start_pay_period' => 'before:end_pay_period' ,
    	'end_pay_period'   => 'after:start_pay_period',
    	);

    public static function validate($pay_period){
    	return Validator::make($pay_period, static::$rules);
    }
} 
<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 11:04 PM
 */

namespace TimeTracking\controllers;

use BaseController, User,  Entry ,Response;

class TimeTrackingPayPeriodController extends BaseController{


	public function postCreatPayPeriod(){
   
    $pay_period = new TimeTrackingPayPeriod();
    $this->postPayPeriod($pay_period);
      
	}

	public function postDeletePeriod(){

		$period = TimeTrackingPayPeriod::find(Input::get('id'));
		try
		{
          $period->delete();
          Response::json(array('status' => 200, 'message' => 'deletion successful'), 200);
		}
		catch(exception $e)
		{
			Response::json(array('status' => 401, 'message' => 'deletion unsuccessful', 'error' => $e), 400);
		}

	}
    
	public function postModifyPeriod(){

		$period = TimeTrackingPayPeriod::find(Input::get('id'));
		$this->postPayPeriod($period);

	}
    
    private function postPayPeriod($pay_period){

		if(!$this->failed(Input::get('start_pay_period')) 
    		&& !$this->failed(Input::get('end_pay_period'))){
    	$start_date = new date("Y-n-j",strtotime(Input::get('start_pay_period')));
    	$end_date = new date("Y-n-j",strtotime(Input::get('end_pay_period')));
    	
    	try
    	{
    		$pay_period['start_pay_period'] = $start_date;
    		$pay_period['end_pay_period']   = $end_date;
    		$pay_period->save();
	    	Response::json(array('status' => 200, 'message' => 'pay period saved'), 200);
    	}
    	catch(exception $e){
        	Response::json(array('status' => 401, 'message' => 'pay period not saved' , 'error' => $e ),401)  
    	}
      }
       else
           Response::json(array('status' => 401, 'message' => 'date is not unique '), 401);	
    }  
    
    private function failed($pay_period){
    	return TimeTrackingPayPeriod::validate($pay_period)->fails();
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 11:04 PM
 * This class is the implementation of the model @see /app/apps/TimeTracking/models/TimeTrackingPayPeriod.php 
 * This will allow the andim to create, delete and modify the payperiods in the database 
 */

namespace TimeTracking\controllers;

use BaseController, User,  Entry ,Response;

class TimeTrackingPayPeriod extends BaseController{

    /**
    * This function is used to create a new payperiod 
    * to be saved to the payperiod table. This function 
    * makes a call to the the helper function and @uses postPayPeriod()
    * create a @see TimeTrackingPayPeriod object and pass it to said function
    */
	public function postCreatPayPeriod(){
   
    $pay_period = new TimeTrackingPayPeriod();
    $this->postPayPeriod($pay_period);
      
	}
    /**
    * This function @uses TimeTrackingPayPeriod::find(Input::get('id'))
    * to find the given payperiod object if it exists. If it doesn't 
    * it , or if the id was not found it exception 
    * @throws an exception and handels it .   
    */
	public function postDeletePeriod() {

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
    /**
    * This function is like , @see postCreatPayPeriod(), but it will  
    * not create a new object of TimeTrackingPayPeriod
    * and instead will find the payperiod by id number and 
    * @uses TimeTrackingPayPeriod::find() to do so. It will pass 
    * that object to the function @uses postPayPeriod($pay_period )
    * for more information on that function please @see postPayPeriod($pay_period)
    */
	public function postModifyPeriod(){

		$period = TimeTrackingPayPeriod::find(Input::get('id'));
		$this->postPayPeriod($period);

	}
    /**
    * This function is a helper function, @see postModifyPeriod()
    * and @see postCreatPayPeriod(). It will validate time and  
    * make sure the payperiod is unique to avoid duplicate dates.
    * If the date is valid it will store the start date and end in the 
    * @param object that is being passed into the function at call .
    * If the object can not be save it @throws an exception       
    */
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
    public function getPayPeriod(){
       return Response::json(array('pay_period' => , TimeTrackingPayPeriod::all()->toArray() ) );
    } 
    /**
    * 
    * This is a helper function that validates if the parameter is
    * is unique to the database table. This function calls 
    * @see /app/apps/TimeTracking/models/TimeTrackingPayPeriod for
    * information on that function.  
    * @param $pay_period the payperiod to validate 
    * @return true if it is unique false other wise.
    */
    private function failed($pay_period){
    	return TimeTrackingPayPeriod::validate($pay_period)->fails();
    }

} 
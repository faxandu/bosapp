<?php
/**
 * @author: brian unused will remove it on next push
 *
 *
 */

namespace TimeTracking\controllers;

use BaseController, Input, User,  Entry ,Response;
use Illuminate\Support\Facades\Auth;
use TimeTracking\models\Categories;
use TimeTracking\models\TimeTrackingEntry;
use TimeTracking\models\TimeTrackingPayPeriod;

class TimeTracking extends  BaseController{
    
    /**
    * This function will allow the user to create a time entry 
    * in the database . 
    */
    public function postCreateTime()
    {
	//$pay = TimeTrackingPayPeriod::
        $timeEntry = new TimeTrackingEntry();
        $timeEntry->user_id = Auth::user()->id;
//        $input = Input::all();
return json($Input::all());


//        $this->postAddTime($timeEntry,$input);
    }
    
    /**
    * This function will eventually take over the modify time and 
    * create time functions.   
    */
    public function postCreateTimeOrModify(){

        $userTime = TimeTrackingEntry::where('id' , ' = ' , Input::get('id'))->count();

        if ($userTime != 0) 
        {
            $this->postAddTime($userTime = new TimeTrackingEntry(), Input::all());
        }
        else
        {    
            $timeEntry = TimeTrackingEntry::find('id')->get();
            $this->postAddTime($timeEntry, Input::all() );
        }


    }
    
    /**
    * This function will delete a time entry for the user 
    *
    */
    public function postDeleteTime()
    {

        $timeEntry = TimeTrackingEntry::find('id');
        
        try{
            $timeEntry->delete();
            Response::json('Message', 'deleted');
        }catch (exception $e){
            return Response::json('Message' , $e);
        }

    }
    
    /**
    * This function will allow the user to modify there time through
    * the pay period . For the reason of mistakes.  
    *
    */
    public function postModifyTime()
    {

        $timeEntry = TimeTrackingEntry::find('id')->get();
        $this->postAddTime($timeEntry, Input::all() );
    }
    /**
    * This function will retreive the current pay period and return the 
    * dates worked for the user to see .  
    * @return $payperiod for the user  
    */
    public function getPayDates()
    {

    $entry = TimeTrackingEntry::where('pay_id' , ' = ' , Input::get('pay_id') )
    ->select( 'start_time' , 'end_time' , 'start_date' , 'end_date')->get();

    return $entry; 

    }
    
    /**
    * The standard miss method function .
    * @return the response of the missig method .
    */
    public function missingMethod($parameters = array()){
        return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
    }
    
    /**
    * This is a helper function to provide flexablity through out the class
    * This function will validate the time and then add the time to the 
    * data base 
    * @param $timeEntry the object to add all the fields to the database
    * @param $input the input to transfer to the @link{#$timeEntry }
    */
    private function postAddTime($timeEntry, $input){
            
        if($this->validateTime(Input::get('start_time')) 
            && $this->validateTime(Input::get('end_time')) ){
            
            $timeEntry->category_id = $input['category_id'];
            $timeEntry->pay_id      = $input['pay_id'];
            $timeEntry->startTime = $input['start_time'];
            $timeEntry->startDate = $input['start_date'];
            $timeEntry->endDate = $input['end_date'];
            $timeEntry->endTime   = $input['end_time'];
            $timeEntry->description = $input['description'];
            
            try{

                $timeEntry->save();
                Response::json(array('status' => 201, 'message' => 'time saved' ), 201);

            }catch(exception $e){
                  Response::json(array( 'status' =>  401 
                    , 'message ' => 'Time Saved Failed ' , 'error ' => $e) ,400);  
            }
         
         }
    }
    /**
     * This is a simple time validation to make sure the time is
     * okay before storing it in the database
     * @param $time that's being passed in to validate
     * @return bool true if the time is valid.
     */

    private function  validateTime($time){

        $timeExplode = explode(':',$time);
        $hours = $timeExplode[0];
        $minutes = $timeExplode[1];
        $seconds = $timeExplode[2];

        if($hours <= 12 && $minutes < 60 && $seconds < 60)
            return (($hours > 0 &&  $minutes >= 0 && $seconds >= 0));

    return false; 

    }
}

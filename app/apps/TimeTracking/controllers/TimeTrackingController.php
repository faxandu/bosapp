<?php
/**
 * @author: brian
 *
 *
 */

namespace TimeTracking\controllers;

use BaseController, Input, User,  Entry ,Response;
use Illuminate\Support\Facades\Auth;
use TimeTracking\models\Categories;
use TimeTracking\models\TimeTrackingEntry;
/**
* This is an implementation of @see 
* /app/apps/TimeTracking/models/TimeTrackingEntry
* This will allow the user to create a new punched in time,
* and end time . With this class it will also allow to modify
* time , delete time . 
* All private functions are located at the bottom .
*/
class TimeTrackingController extends  BaseController{

    /**
    * This function will create an new TimeTrackingEntry 
    * object. This function calls the Auth::user() to validate 
    * the users id for more information see 
    * @link http://laravel.com/docs/security .
    * This function calls a helpe function @see validateTime() to
    * validate time. 
    * @throws an exception if the obect can't be saved.
    */
    public function postCreateTime(){

        $timeEntry = new TimeTrackingEntry();
        $timeEntry->user_id = Auth::user()->id;
        $input = Input::all();

        if($this->validateTime(Input::get('start_time')) && $this->validateTime(Input::get('end_time')) ){
            $this->postAddTime($timeEntry);
            try{
                $timeEntry->save();
               return  Response::json(array('status' => 200, 'message' => 'time was saved '),200 );
            }catch (exception $e){
                return Response::json(array('status' => 401, 'message' => 'time was not saved', 'error' => $e), 401);
            }
        }

    }
    /*
    Alternet version for adding time.
    public function postCreateTime(){

        if(Auth::validate(Input::get('id')) ){
            TimeTrackingEntry::create(Input::all());
        }
    }
    */
    /**
    * This function will allow the user to retrieve a time based 
    * on the id . This function calls find() which is inherited from  
    * BaseController @link http://laravel.com/docs/eloquent
    * which extends eloquent. If found it will delete the entery
    */
    public function postDeleteTime(){

        $timeEntry = TimeTrackingEntry::find('id');

        try{
            $timeEntry->delete();
            return Response::json(array('status' => 201, 'message' => 'time was deleted '),200 );
        }catch (exception $e){
            return Response::json(array( 'status' => 401, 'message' => 'time was not saved' , 'error' => $e), 401);
        }



    }
    /**
    *
    * This will allow the use to modify a time that was entered into
    * the database. This function calls the helper function findOrFail()
    * @link http://laravel.com/docs/eloquent for more information on that.
    * After the time has been validated @see validateTime() it will add the 
    * time via helper function @see postAddTime(), and then save the time.
    * @throws exception if the time couldn't be saved.
    */
    public function postModifyTime(){

        $timeEntry = TimeTrackingEntry::findOrFail('id')->get();

        if($this->validateTime(Input::get('start_time')) && $this->validateTime(Input::get('end_time')) ){
            $this->postAddTime($timeEntry);
            try{
                $timeEntry->save();
                return Response::json(array('status' => 200 , 'message' => 'time was saved '), 200);
            }catch (exception $e){
                return Response::json(array('status' => 401, 'message' => 'time was not saved ', 'error' => $e),401);
            }
        }

    }
    /*
    Alternet version of the modiy time.
    public function postModifyTime(){
        
        if(Auth::validate(Input::get('id')) )
            TimeTrackingEntry::update(TimeTrackingEntry::find('id'));

    }
     
    */
    public function getUserTime(){
         $time = TimeTrackingEntry::find(Auth::user()->id);
       return  Response::json(array('start_time' => $time['start_time'] , 'end_time' => $time['end_time'], 'category' 
            => $time['category'] ) );
         
    }

    public function getCategories(){
         
      return  Response::json(array('category' => Categories::select('category')
            ->where('id', '=' ,Input::get('category_id') )->toArray() ) );
    }
    /**
    * This function will retreive the current pay period and return the 
    * dates worked for the user to see .  
    * @return $payperiod for the user  
    */
    public function getPayDates()
    {

    return Response::json(TimeTrackingEntry::where('pay_id' , ' = ' , Input::get('pay_id') )
    ->select( 'start_time' , 'end_time' , 'start_date' , 'end_date')->all()->toArray() ); 

    }
    
    public function getAllPayDays(){
        return Response::json(TimeTrackingPayPeriod::all()->toArray() );
    }

    public function missingMethod($parameters = array()){
        return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
    }
    /**
    * This is a helper function that will do all the work for class
    * in the form of adding or modifying time . This function calls
    * Input @link http://laravel.com/docs/requests for more information
    * on this , and saves the correct fields it the correct places in 
    * the database. 
    */
    private function postAddTime($timeEntry){

        $timeEntry->category_id = Input::get('category_id');
        $timeEntry->startTime = Input::get('start_time');
        $timeEntry->startDate = Input::get('start_date');
        $timeEntry->endDate = Input::get('end_date');
        $timeEntry->endTime   = Input::get('end_time');
        $timeEntry->description = Input::get('description');

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

    return false; // Time wasn't valid..

    }


}

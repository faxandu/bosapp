<?php
/**
 * @author: brian
 *
 *
 */

namespace TimeTracking\controllers;

use BaseController, Input, User,  Entry ,Response;
use Illuminate\Support\Facades\Auth;

class TimeTrackingController extends  BaseController{

    public function postCreateTime(){

        $timeEntry = new Entry;
        $timeEntry->user = Auth::user()->id;

        if($this->validateTime(Input::get('start_time')) && $this->validateTime(Input::get('end_time')) ){

            $timeEntry->startTime = Input::get('start_time');
            $timeEntry->startDate = Input::get('start_date');
            $timeEntry->endDate = Input::get('end_date');
            $timeEntry->endTime   = Input::get('end_time');
            $timeEntry->description = Input::get('description');

            try{
                $timeEntry->save();
                Response::json('Message','Time saved');
            }catch (exception $e){
                Response::json('Message',$e);
            }
        }
    }

    public function postDeleteTime(){


        try{
            Entry::delete(Input::get('id'));
            Response::json('Message', 'deleted');
        }catch (exception $e){
            return Response::json('Message' , $e);
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

        if($hours <= 12 && $minutes < 60 &&$seconds < 60)
            return (($hours > 0 &&  $minutes >= 0 && $seconds >= 0));

    return false; // something failed in the if statement.
    }
}

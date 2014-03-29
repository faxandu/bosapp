<?php
/**
 * @author: brian
 *
 *
 */

namespace TimeTracking\controllers;

use BaseController, Input, User,  Entry ,Response;

class TimeTrackingController extends  BaseController{


    public function postCreateTime(){

        $userEntry = Input::get('username');
        $timeEntry = new Entry;
        $timeEntry->startTime = Input::get('start_time');
        $timeEntry->startDate = Input::get('start_date');
        $timeEntry->endDate = Input::get('end_date');
        $timeEntry->endTime   = Input::get('end_time');
        $timeEntry->description = Input::get('description');

        if($this->validateTime($timeEntry->startTime) && $this->validateTime($timeEntry->end_time)){


        }

    }

    public function postUpdateTime(){



    }

    /**
     * This is a simple time validation to make sure the time is
     * okay before storing it in the database
     * @param $time
     * @return bool
     */
    private function  validateTime($time){

        $timeExplode = explode(':',$time);
        $hours = $timeExplode[0];
        $minutes = $timeExplode[1];
        $seconds = $timeExplode[2];

        if($hours < 24 && $minutes < 60 &&$seconds < 60)
            return (($hours > 0 &&  $minutes >= 0 && $seconds >= 0));
        else
            return false;

    }
}

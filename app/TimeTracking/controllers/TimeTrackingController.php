<?php
/**
 * @author: brian
 *
 *
 */

namespace TimeTracking\controllers;

use BaseController, Input, User,  Entry ,Response;

class TimeTrackingController extends  BaseController{


    public function postUpdateTime(){

        $userInfo = Input::get('all');
        $user = User::where('student_num', $userInfo['username'])->pluck('id');

        if($this->validateTime($userInfo['time'])){


        }

    }

    public function postDeleteTime(){

    }

    /**
     * This is a simple time validation to make sure the time is
     * okay before storing it in the database
     * @param $time
     * @return bool
     */
    public function  validateTime($time){

        $timeExplode = explode(':',$time);
        $hours = $timeExplode[0];
        $minutes = $timeExplode[1];
        $seconds = $timeExplode[2];

        if($hours < 24 && $minutes < 60 &&$seconds < 60)
            return (($hours > 0 &&  $minutes > 0 && $seconds > 0));
        else
            return false;

    }
}

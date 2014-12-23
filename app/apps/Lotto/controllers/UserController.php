<?php 

namespace Lotto\controllers;

use BaseController, User;
use Lotto\models\Skill;
use Auth, View;
use Input, Response, Exception, Session, Redirect;

class UserController extends BaseController {

	
	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/




	/* returns the user and their courses.
	--------- */
	public function getMySchedule(){

		$this->layout->content = View::make('lotto.schedule.home')->with(array(

			'user' => Auth::user(),
			'userCourses' => Auth::user()->courses

			));
	}





	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/




	public function postUpdatePreferedHours(){

		$userId = Input::get('user');
		$hours = Input::get('hours');

		try{

			if($hours > 20)
				throw new exception("Must be below 20 hours");

			$user =	User::findOrFail($userId);

			$user->prefered_hours = $hours;
			$user->save();


		} catch(exception $e){
			return Redirect::to('/schedule/availability/my-availability')->with( 
			array( 
				'message' => 'failed to update hours () e',
				//'message' => $e->getMessage()
			));
		}

		
		return Redirect::to('/schedule/availability/my-availability')->with( 
			array(
				'message' => 'updated prefered hours'
			));

	}
}

<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Availability, User;
use Auth, ControllerHelper;
use Input, Response, Exception, Session, Redirect;
use View;

class AvailabilityController extends BaseController {


	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/

	/* 
		REQUIRES: GET

		URL: /schedule/availability/create 

		Sets the content variable inside the layout to be the create view from lotto.availability.
	
	*/
	public function getCreate(){

		$this->layout->content = View::make('lotto.availability.create');
	}

	/*
		REQUIRES: GET
		
		URL: /schedule/availability/my-availability

		Sets the content variable inside the layout to be the home view from lotto.availability.
		Also attaches the currently logged in user, that users availabiltiy, and any variables stored
		in the session (other functions redirect to this function). 
	
	*/
	public function getMyAvailability(){

		$this->layout->content = View::make('lotto.availability.home')->with(array(

			'user' => Auth::user(), 
			'userAvailability' => Auth::user()->availability,
			Session::all()

		));

	}



	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/

	/*
		REQUIRES: POST

		URL: /schedule/availability/create


		EXPECTS: 
			end_date -- date
			start_date -- date
			end_time	-- time
			start_time -- time
			notes -- text
			title -- string - 50
	
	*/
	public function postCreate(){
	
		$input = Input::all();
		$input = ControllerHelper::convertTimeAndDate($input);
		$this->layout->content = ControllerHelper::create(
			new Availability, $input,
			'/schedule/availability/my-availability', '/schedule/availability/create',
			'availability', Auth::user()
			);
	}	


	/*	
		REQUIRES: POST

		URL: /schedule/availability/delete

		EXPECTS: id => int


		Feature? only if no users attached then delete?

		
	----------------------------------- */
	public function postDelete(){

		$this->layout->content = ControllerHelper::delete(
			new Availability, Input::all(), '/schedule/availability/my-availability');
	}

}


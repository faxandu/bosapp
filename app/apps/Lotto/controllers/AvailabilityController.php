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
		URL: /schedule/availability/create 

		Sets the content inside the layout to be the create view from lotto.availability.
	
	*/
	public function getCreate(){

		$this->layout->content = View::make('lotto.availability.create');
	}

	/*		
		URL: /schedule/availability/my-availability

		
	
	*/
	public function getMyAvailability(){

		$this->layout->content = View::make('lotto.availability.home')->with(array(

			'user' => Auth::user(), 
			'userAvailability' => Auth::user()->availability,
			Session::all()

		));

	}


	public function getUpdate(){


		$this->layout->content = View::make('lotto.availability.update')->with(array(

			'user' => Auth::user(), 
			'userAvailability' => Auth::user()->availability->find(input::get('id')),
			Session::all()

		));
	}


	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/

	/*
		URL: /schedule/availability/create


		EXPECTS: 
	

			creats an availability 
	
		TODO:
			Start time should be less than end -- data validation

	*/
	public function postCreate(){



			
		$input = Input::all();
		$input = ControllerHelper::convertTimeAndDate($input);


		return ControllerHelper::create(
				new Availability, 
				$input,
				'/schedule/availability/my-availability',
				'/schedule/availability/create',
				'availability',
				Auth::user()
			);

	}	


	public function postUpdate(){
			
		$input = Input::all();
		$input = ControllerHelper::convertTimeAndDate($input);

		$route_pass = "/schedule/availability/my-availability";
		$route_fail = '/schedule/availability/update?id=' . $input['id'];
		return ControllerHelper::update(
				new Availability, 
				$input,
				$route_pass,
				$route_fail
			);

	}

	/*	
		URL: /schedule/availability/delete

		EXPECTS: id => int


		Feature? only if no users attached then delete?


		Deletes an availability
		
	----------------------------------- */



	public function getDelete(){

		return ControllerHelper::delete(
				new Availability,
				Input::all(),
				'/schedule/availability/my-availability'
			);
	}




}


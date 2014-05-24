<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Availability, User;
use Auth;
use Input, Response, Exception, Session, Redirect;
use View;

class AvailabilityController extends BaseController {


	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/

	public function getCreate(){

		$this->layout->content = View::make('lotto.availability.create');
	}


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
		Feature? If a time already exists just add a link to user?


	----------------------------------- */
	public function postCreate(){
	
		$input = Input::all();

		$checkedInput = Availability::validate($input);

		if($checkedInput->fails()){

			return Redirect::to('/schedule/availability/create')->with(array(
				'status' => 400,
				'error' => $checkedInput->messages()->all()
			));
		
		}

		try{

			$user = Auth::user();

			$availability = availability::create($input);

			$user->availability()->attach($availability);


		} catch(Exception $e){

			return Redirect::to('/schedule/availability/create')->with(array(
				'error' => $e->getMessage()
			));

		}

		return Redirect::to('/schedule/availability/my-availability')->with(array(
				'status' => 200
			));;
	}	


	/*	
		Feature? only if no users attached then delete?


	----------------------------------- */
	public function postDelete(){
		
		$id = Input::get('id');

		try{ 
			

			$availability = Availability::findOrFail($id);
			
			$availability->delete();

		}catch(exception $e){
			
			return Redirect::to('/schedule/availability/my-availability')->with(array(
				'error' => $e->getMessage()
			));
		}
		
			return Redirect::to('/schedule/availability/my-availability')->with(array(
				'status' => 200
			));;
	}



	// public function postRemoveAvailabilityFromUser(){
	// 	$userId = Input::get('user');
	// 	$availabilityId = Input::get('availability');

	// 	try{
			

	// 		User::findorFail($userId)->availability()->detatch($availabilityId);

	// 	}catch(exception $e){
	// 		return Response::json(array('status' => 400, 	
	// 		'message' => 'Failed to remove Availability.', 'error' => $e->getMessage()), 400);
	// 	}

	// 	return Response::json(array('status' => 200, 'message' => 'Availability removed'), 200);
	// }

}


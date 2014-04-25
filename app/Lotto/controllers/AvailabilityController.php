<?php 
 namespace Lotto\controllers;

use BaseController, Lotto\models\Availability, User;
use Input, Response, Auth, Exception;
use View;

class AvailabilityController extends BaseController {

	public function getMyAvailability(){

		// give the user availability.

		// each course they have.


		$this->layout->content = View::make('lotto.availability')
		->with(array('user' => Auth::user(), 'userAvailability' => Auth::user()->availability));
	}

	public function postCreate(){
		$input = Input::all();
		
		//$validatedInput = Course::validate(Input::all());

		//$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		//if(!$messages->all()){
			try{

				$availability = Availability::create($input);

				return Response::json(array('status' => 201, 'message' => 'Availability created'), 201);

			}catch(Exception $e){
				return Response::json(array('status' => 400, 
					'message' => 'Failed to create Availability', 'error' => $e), 400);
			}
		//}
		// return Response::json(array('status' => 400,
		 // 'message' => 'Failed to create Availability', 'error' => $messages->all() ), 400);
	}	

	public function postDelete(){
		
		try{ 
			$id = Input::get('id');

			$availability = Availability::findOrFail($id);
			
			$availability->delete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete Availability.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Course Deleted'), 200);
	}

	public function getGet(){
		
		try{	

			if(!Input::has('id'))
				return Response::json(Availability::all());

			$id = Input::get('id');

			$availability = Availability::findOrFail($id);
			
			return Response::json($availability->toarray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get Availability.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function postRemoveAvailabilityFromUser(){
		$userId = Input::get('user');
		$availabilityId = Input::get('availability');

		try{
			

			User::findorFail($userId)->availability()->detatch($availabilityId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove Availability.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'Availability removed'), 200);
	}

	public function postSetAvailabilityToUser(){
		$availabilityId = Input::get('availability');
		$userId = Input::get('user');
		
		try{

			$user = User::findorFail($userId);
			$availability = Availability::findorFail($availabilityId);

			$user->availability()->attach($availability);

		}catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign Availability', 'error' => $e->getMessage()), 400);
		}
		
		return Response::json(array('status' => 201, 'message' => 'Availability assigned'), 201);
	 }	

}


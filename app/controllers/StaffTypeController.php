<?php

class StaffTypeController extends BaseController {

	public function delete(){
		
		if(Input::has('id')){
			$id = Input::get('id');

			Staff::findOrFail($id)->forceDelete();		
			return Response::json(array("deleted"));
		}
		app::abort(400);
	}

	
	public function get(){
		
		if(Input::has('id')){
			$id = Input::get('id');

			$Staff = Staff::findOrFail($id)->toArray();
			return Response::json($Staff);
		}
		return Response::json(Staff::all());
	}

	public function getUserStaffType(){

		if(Input::has('id')){
			$id = Input::get('id');
			$users = array();

			$user = User::findOrFail($id);
			array_push( array('user' => $user->toarray(),
			'staff' => $user->stafftypeArr()), $users);
			
			return Response::json($users);
		}
		app::abort(400);
	}

	public function set(){

		if(Input::has('type')){
			$input = Input::all();

			//update or create
			//************************ update currently wipes old data 

			$Staff = (Input::has('id')) ? Staff::find($input['id'])->update($input) : Staff::create($input);
			
			return Response::json(array("response" => "created"));
		}
		app::abort(400);
	}


	public function setUserStaffType(){
		if(Input::has('user_id') && Input::has('staff_id')){

			$userId = Input::get('user_id');
			$staffId = Input::get('staff_id');

			User::findOrFail($userId)->staffType()->attach($staffId);

			return Response::json(array("set Staff"));
		}

		app::abort(400);
	}

}
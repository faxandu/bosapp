<?php

class UserController extends BaseController {


	public function delete(){

		if(Input::has('id')){

			$id = Input::get('id');		
			User::findOrFail($id)->forceDelete();
			return Response::json(array("deleted"));
		}
		app::abort(400);
	}

	public function deleteUserSkill(){
		if(Input::has('user_id') && Input::has('skill_id')){
			
			$id = Input::get('user_id');
			
			User::findOrFail($id)->skills()->detach(Input::get('skill_id'));

			return Response::json(array("deleted Skill"));
		}

		app::abort(400);
	}


	public function get(){

		if(Input::has('id')){
						
			$id = Input::get('id');

			return Response::json(User::findOrFail($id)->toArray());
		}
		return Response::json(User::all());
	}


	public function getUserSkill(){

		if(Input::has('id')){

			$id = Input::get('id'); 

			$user = User::findOrFail($id);
			$userSkills = array('user' => $user->toarray(),
			'skills' => $user->skillsArr() );
			
			return Response::json($userSkills);
		}
		app::abort(400);
	}

	public function set(){
		

		if(Input::has('name')){
			$input = Input::all();
			//update or create
			//************************ update currently wipes old data 
			$user = (Input::has('id')) ? User::find(Input::get('id'))->update($input) : User::create($input);

			return Response::json(array("response" => "created"));
		}
		app::abort(400);
	}


	public function setUserSkill(){
		if(Input::has('user_id') && Input::has('skill_id')){

			$userId = Input::get('user_id');
			$skillId = Input::get('skill_id');
						
			User::findOrFail($userId)->skills()->attach($skillId);

			return Response::json(array("set Skill"));
		}

		app::abort(400);
	}



}
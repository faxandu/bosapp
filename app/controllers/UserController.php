<?php

class UserController extends BaseController {


	public function setUser(){
		$input = Input::all();

		if(Input::has('name')){

			//update or create
			//************************ update currently wipes old data 

			$user = (Input::has('id')) ? User::find(Input::get('id'))->update($input) : User::create($input);


			return Response::json(array("response" => "created"));
		}

		app::abort(400);
	}



	public function getUser(){

		if(Input::has('id')){
						
			$iUser = Input::get('id');			
			
			return Response::json(User::findOrFail($id)->toArray());
		}
		return Response::json(User::all());
	}

	public function deleteUser(){

		if(Input::has('id')){

			$iUser = Input::get('id');			
			
					
			User::findOrFail($iUser)->forceDelete();
			
			return Response::json(array("deleted"));
		}

		app::abort(400);
	}

	public function setUserSkill(){
		if(Input::has('user_id') && Input::has('skill_id')){

			$iUser = Input::get('user_id');
			$iSkill = Input::get('skill_id');
						
			User::findOrFail($iUser)->skills()->attach($iSkill);

			return Response::json(array("set Skill"));
		}

		app::abort(400);
	}

	public function deleteUserSkill(){
		if(Input::has('user_id') && Input::has('skill_id')){
			
			$users[] = Input::get('user_id');
			
			foreach ($users as $id ){				
			
				$user = User::findOrFail($id)->skills()->detach(Input::get('skill_id'));

			}

			return Response::json(array("deleted Skill"));
		}

		app::abort(400);
	}

	public function getUserSkill(){

		if(Input::has('id')){
			
			$users = array();
			$input = array(Input::get('id')); 
			
			foreach ($input as $id ){

				$user = User::findOrFail($id);
				$arr = array('user' => $user->toarray(),
				'skills' => $user->skillsArr() );
				array_push($users, $arr);
			}

			return Response::json($users);
		}
		app::abort(400);
	}
}
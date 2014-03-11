<?php

class SkillController extends BaseController {

	public function delete(){
		
		try{
			$id = Input::get('id');

			Skill::findOrFail($id)->forceDelete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete Skill.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Skill Deleted'), 200);
	}

	public function get(){
		
		try{	

			if(!Input::has('id'))
				return Response::json(Skill::all());

			$id = Input::get('id');

			$skill = Skill::findOrFail($id);
			

			return Response::json($skill->toArray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get skill.', 'error' => $e->getMessage()), 400);
		}		
	}

		public function getUserSkill(){

		try{	
			$id = Input::get('id');
			$user = User::findOrFail($id);

			$users = array();
			array_push($users, array('user' => $user->toarray(),
			'skills' => $user->skillsArr()));

			return Response::json($users);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get skills.', 'error' => $e->getMessage()), 400);
		}
	}

	public function removeUserSkill(){
		
		try{
			$userId = Input::get('user');
			$skillId = Input::get('skill');

			User::findorFail($userId)->skills()->detatch($skillId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove userSkill.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'userSkill removed'), 200);
	}

	public function setUserSkill(){
		$userId = Input::get('user');
		$skill = Input::get('skill');
		try{

			User::findOrFail($userId)->skills()->attach($skill);
		}catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign skill', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 201, 'message' => 'skill assigned'), 201);
	}


}
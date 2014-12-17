<?php 
namespace Lotto\controllers;

use BaseController, Lotto\models\Skill, User;
use Response, Input, Exception;

class SkillController extends BaseController {



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
		/////////////URL: /schedule/availability/delete

		EXPECTS: id => int


		Skills should not be deleted via this method?

		
	----------------------------------- */
	public function postDelete(){
		
		$id = Input::get('id');

		try{
			
			Skill::findOrFail($id)->delete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete Skill.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Skill Deleted'), 200);
	}

	public function getGet(){
		return Response::json(Skill::all());	
	}

	public function postGet(){
		
		$id = Input::get('id');

		try{	

			$skill = Skill::findOrFail($id);			

			return Response::json($skill->toArray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get skill.', 'error' => $e->getMessage()), 400);
		}		
	}
	
	public function postGetUserSkill(){

			$id = Input::get('id');

		try{	
			
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

	public function postRemoveUserSkill(){
		
			$userId = Input::get('user');
			$skillId = Input::get('skill');

		try{
			
			User::findorFail($userId)->skills()->detatch($skillId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove userSkill.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'userSkill removed'), 200);
	}


	/*
		attaches a skill to the user.

		takes id for user and id for a skill.

	*/

	public function postSetUserSkill(){
		$userId = Input::get('user');
		$skill = Input::get('skill');
		
		try{

			User::findOrFail($userId)->skills()->attach($skill);

		} catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign skill', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 201, 'message' => 'skill assigned'), 201);
	}


	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}


<?php

namespace Lotto\controllers;

use BaseController, Lotto\models\Availability, Lotto\models\Course, Lotto\models\Skill, User;
use Auth;
use Input, Response, Exception, Session, Redirect;
use View;

class AdminController extends BaseController {

	public function getIndex() {

		$this->layout->content = View::make('admin.lotto.home', array(
			'users' => User::all(),
			'courses' => Course::all(),
			'skills' => Skill::all()
			));
	}

	public function getSkills($id) {
		$user = User::find($id);

		return Response::json(array('user' => $user->toArray(), 'skills' => $user->skills->toArray()));
	}

	public function postSetSkill() {

		$user = Input::get('user');
		$skill = Input::get('skill');

		try{

			$user = User::findorFail($user);
			$skill = Skill::findorFail($skill);

			$user->skills()->attach($skill);

			/*
			$this->layout->content = Redirect::to('admin/schedule/user/all')->with(array(
				'status' => 200,
				
				));
			*/
			return Response::json(array(
				'message' => 'Skill Added to User',
				'status' => 200,
			));


		}catch(Exception $e){

			/*
			$this->layout->content = Redirect::to('admin/schedule/user/set-skills')->with(array(
				'status' => 400,
				'error' => 'deletion failed'
				));
			*/
			return Response::json(array(
				'message' => 'Skill Addition Failed',
				'status' => 400,
			));

		}
	
	}

	public function postDropSkill() {

		$user = Input::get('user');
		$skill = Input::get('skill');

		try{

			$user = User::findorFail($user);
			$skill = Skill::findorFail($skill);

			$user->skills()->detach($skill);

			/*
			$this->layout->content = Redirect::to('admin/schedule/user/all')->with(array(
				'status' => 200,
				
				));
			*/
			return Response::json(array(
				'message' => 'Skill Removed From User',
				'status' => 200,
			));


		}catch(Exception $e){

			/*
			$this->layout->content = Redirect::to('admin/schedule/user/set-skills')->with(array(
				'status' => 400,
				'error' => 'deletion failed'
				));
			*/
			return Response::json(array(
				'message' => 'Skill Removal Failed',
				'status' => 400,
			));

		}
	
	}

}
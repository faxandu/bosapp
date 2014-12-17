<?php 

namespace Lotto\controllers;

use BaseController, User;
use Lotto\models\Skill;
use Auth, View;
use Input, Response, Exception, Session, Redirect;

class UserController extends BaseController {

	
	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/




	/* returns the user and their courses.
	--------- */
	public function getMySchedule(){

		$this->layout->content = View::make('lotto.schedule.home')->with(array(

			'user' => Auth::user(),
			'userCourses' => Auth::user()->courses

			));
	}


	/* For admin: return list of all users who can labaide.
	--------- */
	public function getAll(){

		$users = User::where('type','=','labAide')->get();

		$this->layout->content = View::make('admin.lotto.userList')->with(array(
			'users' => $users
			));
	}


	public function getSetSkills(){

		$this->layout->content = View::make('admin.lotto.set_skills')->with(Session::all());
	
	}

	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/


	public function postSetSkills(){

		$user = Input::get('user');
		$skill = Input::get('skill');

		try{

			$user = User::findorFail($user);
			$skill = Skill::findorFail($skill);

			$user->skills()->attach($skill);

			$this->layout->content = Redirect::to('admin/schedule/user/all')->with(array(
				'status' => 200,
				
				));

		}catch(Exception $e){

			$this->layout->content = Redirect::to('admin/schedule/user/set-skills')->with(array(
				'status' => 400,
				'error' => 'deletion failed'
				));

		}

		return $this->layout->content;
	
	}
}

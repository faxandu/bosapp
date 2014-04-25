<?php 

namespace Lotto\controllers;

use BaseController, User;
use Input, Response, Auth, Exception;
use View;

class UserController extends BaseController {

	/* returns the user and their courses.
	--------- */
	public function getMySchedule(){

		// give the user schedule.

		// each course they have.


		$this->layout->content = View::make('lotto.schedule')
		->with(array('user' => Auth::user(), 'userCourses' => Auth::user()->courses));
	}


	/* For admin: return list of all users who can labaide.
	--------- */
	public function getAll(){

		$users = User::where('type','=','labAide')->get();

		$this->layout->content = View::make('admin.lotto.userList')
		->with(array('users' => $users));
	}


	public function getGet(){
		$this->layout->content = View::make('lotto.user.list')->withUsers(User::all());		
	}

	
}

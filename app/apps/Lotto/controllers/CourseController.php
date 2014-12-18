<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Course, Lotto\models\Skill, User;
use Input, Response, Redirect, Session, Exception;
use View;

class CourseController extends BaseController {




	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/




	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/





	/* Removes a user as a labaide from a course.
	------------------ */
	public function postRemoveLabaide(){
		
		$userId = Input::get('user');
		$courseId = Input::get('course');

		try{		
			Course::findorFail($courseId)->labaides()->detach($userId);

		}catch(exception $e){
			return Redirect::to('admin/schedule/home')->with( 
			array( 
			'message' => 'failed to remove labaide'
			));
		}

		return Redirect::to('admin/schedule/home')->with( 
			array(
			'message' => 'removed labaide'
			));
	}




	/*
		takes id for course and user.

		assigns the course to the user

	*/

	public function postSetLabaide(){
		
		$courseId = Input::get('course');
		$userId = Input::get('user');
		
		try{

			$user = User::findorFail($userId);
			$course = Course::findorFail($courseId);
			
			if(Course::checkUser($user, $course)){

				$course->labaides()->detach();
				$course->labaides()->attach($user);
			} else
				throw new Exception("Not able to assign");

		}catch(exception $e){

			return Redirect::to('admin/schedule/home')->with( 
			array('status' => 200, 
			'message' => 'failed to assign labaide' . $e->getMessage()
			));
		}
		
		return Redirect::to('admin/schedule/home')->with( 
			array('status' => 200, 
			'message' => 'assigned labaide'
			));
	 }


	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

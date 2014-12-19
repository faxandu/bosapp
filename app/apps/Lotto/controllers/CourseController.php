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

	public function postUpdateCourseNeedsCoverage(){

		$needsCoverage = Input::get('coverage');
		$courseId = Input::get('course');


		try{

			if($needsCoverage == "true")
				$needsCoverage = true;
			else
				$needsCoverage = false;

			$course = Course::findorFail($courseId);

			$course->needs_coverage = $needsCoverage;

			$course->save();

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
			
			if($user->checkEligibilityToLabaide($course)){

				$course->labaides()->detach();
				$course->assingLabaide($user);
			} else
				throw new Exception("Not able to assign");

		}catch(exception $e){

			return Redirect::to('admin/schedule/home')->with( 
			array(
			'message' => 'failed to assign labaide ',
			'message' => $e->getMessage()
			));
		}
		
		return Redirect::to('admin/schedule/home')->with( 
			array(
			'message' => 'assigned labaide'
			));
	 }








	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

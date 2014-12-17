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



	/*	Admin: deletes a course.
		Grab a course and delete it,
		then redirect to the listing page. 
	--------------- */
	public function postDelete(){
		
		echo "delete";

		exit;

		$id = Input::get('id');
		
		try{

			$course = Course::findOrFail($id);

			$course->delete();

		}catch(exception $e){

			return Redirect::to('admin/schedule/course/all')->with(array(
				'status' => 400,
				'message' => 'Failed to Delete Course',
				'error' => $e
				));
			
		}

		return Redirect::to('admin/schedule/course/all')->with(array(
				'status' => 200,
				));
	}




	/* Removes a user as a labaide from a course.
	------------------ */
	public function postRemoveLabAide(){
		
		$userId = Input::get('user');
		$courseId = Input::get('course');

		try{		
			Course::findorFail($courseId)->labaides()->detatch($userId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove labAide.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'labAide removed'), 200);
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

	 	public function postUpdate(){

		$validatedInput = Course::updateValidate(Input::all());
		$messages = $validatedInput->messages();
		$id = Input::get('id');
		// if any error messages, don't update and return errors.
		if(!$messages->all()){

			try{	

				$course = Course::find($id);
				$course->update(Input::all());
				
			}catch(exception $e){
				return Response::json(array('status' => 400, 	
				'message' => 'Failed to update course.', 'error' => $e->getMessage()), 400);
			}	
		} else{
			return Response::json(array('status' => 400,
		 'message' => 'Failed to update course', 'error' => $messages->all() ), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'Course Updated'), 200);

	}

	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

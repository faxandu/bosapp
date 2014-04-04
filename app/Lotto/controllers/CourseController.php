<?php 

namespace Lotto\controllers;
use BaseController, Input, Lotto\models\Course, Response;

class CourseController extends BaseController {


	public function postCreate(){

		$input = Input::all();
		$validatedInput = Course::validate(Input::all());
		$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		if(!$messages->all()){
			try{

				$course = Course::create($input);

				return Response::json(array('status' => 201, 'message' => 'Course created'), 201);

			}catch(Exception $e){
				return Response::json(array('status' => 400, 
					'message' => 'Failed to create course', 'error' => $e), 400);
			}
		}
		return Response::json(array('status' => 400,
		 'message' => 'Failed to create course', 'error' => $messages->all() ), 400);
	}

	public function getImport(){
		
		$file = file_get_contents($_ENV['courseLink']);

		$data = json_decode($file, true);
	
		foreach($data as  $value){
			Course::create(
					array(

						'end_time' => $value['END_TIME'],
						'building' => $value['BUILDING'],
						'term_code' => $value['TERM_CODE'],
						'crn' => $value['CRN'],
						'days_of_week' => $value['DAYS'],
						'instructor' => $value['INSTRUCTOR'],
						'start_time' => $value['BEGIN_TIME'],
						'start_date' => $value['START_DATE'],
						'section' => $value['SECTION'],
						'course_number' => $value['COURSE_NUMBER'],
						'room_number' => $value['ROOM_NUMBER'],
						'subject_code' => $value['SUBJECT_CODE'],
						'course_title' => $value['COURSE_TITLE'],
						'part_of_term' => $value['PART_OF_TERM'],
						'end_date' => strtotime($value['END_DATE'])
						)
				);
		}

		return Course::all();

		exit;
	}

	public function postDelete(){
		
		$id = Input::get('id');
		
		try{
			
			$course = Course::findOrFail($id);
			$course->labAides()->detach();
			$course->forceDelete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete course.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Course Deleted'), 200);
	}

	public function getGet(){
		return Response::json(Course::all());		
	}

	public function postGet(){
		
		$id = Input::get('id');

		try{	
			
			$course = Course::findOrFail($id);
			$course->labAides->toArray();
			
			return Response::json($course->toArray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get course.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function postRemoveLabAide(){
		
		$userId = Input::get('user');
		$courseId = Input::get('course');

		try{		
			Course::findorFail($courseId)->labAides()->detatch($userId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove labAide.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'labAide removed'), 200);
	}

	public function postSetLabAide(){
		$courseId = Input::get('course');
		$userId = Input::get('user');
		
		try{

			$user = User::findorFail($userId);
			$course = Course::findorFail($courseId);
			
			if(Course::checkUser($user, $course)){
				$course->labAides()->attach($user);
			}

		}catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign labAide', 'error' => $e->getMessage()), 400);
		}
		
		return Response::json(array('status' => 201, 'message' => 'LabAide assigned'), 201);
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

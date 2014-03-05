<?php

class CourseController extends BaseController {

	public function create(){
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

	public function delete(){
		
		try{
			$id = Input::get('id');

			$course = Course::findOrFail($id);
			$course->labAides()->detach();
			$course->forceDelete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete course.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Course Deleted'), 200);
	}

	public function get(){
		
		try{	

			if(!Input::has('id'))
				return Response::json(Course::all());

			$id = Input::get('id');

			$course = Course::findOrFail($id);
			$courseArr = $course->toArray();

			array_push($courseArr, array('labAide' => $course->labAides->toArray()));
			
			return Response::json($courseArr);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get course.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function removeLabAide(){
		
		try{
			$userId = Input::get('user');
			$courseId = Input::get('course');

			Course::findorFail($courseId)->labAides()->detatch($userId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove labAide.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'labAide removed'), 200);
	}

	public function setLabAide(){
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

	 	public function update(){

		$validatedInput = Course::updateValidate(Input::all());

		$messages = $validatedInput->messages();

		// if any error messages, don't update and return errors.
		if(!$messages->all()){

			try{	
				
				$id = Input::get('id');
				
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
}
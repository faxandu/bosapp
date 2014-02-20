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
			Course::findOrFail($id)->forceDelete();

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
			$courseArr = $course->toarray();
			array_push($courseArr, $course->labAideArr());
			return Response::json($courseArr);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get course.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function set(){
		
		if(Input::has('name')){
			$input = Input::all();

			if ( !$input['labAide'] ) 
				$input['labAide'] = NULL;


			//update or create
			//************************ update currently wipes old data if blank
			$course = (Input::has('id')) ? Course::find($input['id'])->update($input) : Course::create($input);

			return Response::json(array('status' => 201, 'message' => 'Course Saved'), 201);
		}

		return Response::json(array('status' => 400, 'message' => 'Failed to Save course'), 400);
	}

	public function setLabAide(){
		$courseId = Input::get('course');
		$userId = Input::get('user');
		
		try{

			$user = User::findorFail($userId);
			$course = Course::findorFail($courseId);
			
			if(Course::checkUser($user, $course)){
				$course->labAide()->attach($user);
			}

		}catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign labAide', 'error' => $e->getMessage()), 400);
		}
		
		return Response::json(array('status' => 201, 'message' => 'LabAide assigned'), 201);
	 }
}
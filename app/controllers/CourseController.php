<?php

class CourseController extends BaseController {

	public function create(){
		$input = Input::all();
		$validatedInput = Course::validate(Input::all());

		$messages = $validatedInput->messages();

		if(!$messages->all()){
		
			try{

				Course::create($input);
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
		
		if(Input::has('id')){
			$id = Input::get('id');
			Course::findOrFail($id)->forceDelete();
			return Response::json(array('status' => 200, 'message' => 'Course Deleted'), 200);
		}
		return Response::json(array('status' => 400, 'message' => 'Course Delete Failure'), 400);
	}

	public function get(){
		if(Input::has('id')){
			
			$id = Input::get('id');

			$course = Course::findOrFail($id)->toArray();
			return Response::json($course);
		}

		return Response::json(Course::all());
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
}
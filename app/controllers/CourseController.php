<?php

class CourseController extends BaseController {


	public function setCourse()
	{
		$input = Input::all();

		if(Input::has('name')){
			if ( !$input['labAide'] ) 
				$input['labAide'] = NULL;
			//update or create
			//************************ update currently wipes old data 

			$course = (Input::has('id')) ? Course::find($input['id'])->update($input) : Course::create($input);
			//app::abort(201);


			return Response::json(array("response" => "created"));
		}

		app::abort(400);
	}



	public function getCourse()
	{

		if(Input::has('id')){
			
			$courses = array();
			$courses[] = Input::get('id');
			foreach ($courses as $id ){				
				$courses[] = Course::findOrFail($id)->toArray();
			}
			return Response::json($courses);
		}
		return Response::json(Course::all());
	}

	public function deleteCourse()
	{
		if(Input::has('id')){
			
			
			$courses[] = Input::get('id');
			foreach ($courses as $id ){				
				Course::findOrFail($id)->forceDelete();
			}
			return Response::json(array("deleted"));
		}

		app::abort(400);
	}

}
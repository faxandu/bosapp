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

			return Response::json(array("response" => "created"));
		}

		app::abort(400);
	}



	public function getCourse()
	{

		if(Input::has('id')){
						
			$course = Course::findOrFail($id)->toArray();

			return Response::json($course);
		}
		return Response::json(Course::all());
	}

	public function deleteCourse()
	{
		if(Input::has('id')){
			Course::findOrFail($id)->forceDelete();
			
			return Response::json(array("deleted"));
		}

		app::abort(400);
	}

}
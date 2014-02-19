<?php

class SkillController extends BaseController {

	public function delete(){
		
		if(Input::has('id')){
			$id = Input::get('id');

			Skill::findOrFail($id)->forceDelete();		
			return Response::json(array('status' => 200, 'message' => 'Skill Deleted'), 200);
		}
		return Response::json(array('status' => 400, 'message' => 'Failed to delete skill'), 400);
	}
	

	public function get(){
		
		if(Input::has('id')){
			$id = Input::get('id');

			$Skill = Skill::findOrFail($id)->toArray();
			
			return Response::json($Skill);
		}
		return Response::json(Skill::all());
	}

	public function set(){

		if(Input::has('name')){
			$input = Input::all();
			
			//update or create
			//************************ update currently wipes old data 
			$Skill = (Input::has('id')) ? Skill::find($input['id'])->update($input) : Skill::create($input);

			return Response::json(array('status' => 201, 'message' => 'Skill Saved'), 201);
		}
		return Response::json(array('status' => 400, 'message' => 'Failed to Save skill'), 400);
	}
}
<?php

class SkillController extends BaseController {

	public function delete(){
		
		try{
			$id = Input::get('id');

			Skill::findOrFail($id)->forceDelete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete Skill.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Skill Deleted'), 200);
	}

	public function get(){
		
		try{	

			if(!Input::has('id'))
				return Response::json(Skill::all());

			$id = Input::get('id');

			$skill = Skill::findOrFail($id)->toArray();
			return Response::json($skill);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get skill.', 'error' => $e->getMessage()), 400);
		}		
	}

}
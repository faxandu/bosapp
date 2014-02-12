<?php

class SkillController extends BaseController {


	public function setSkill()
	{
		$input = Input::all();

		if(Input::has('name')){

			//update or create
			//************************ update currently wipes old data 

			$Skill = (Input::has('id')) ? Skill::find($input['id'])->update($input) : Skill::create($input);
			//app::abort(201);

			
			return Response::json(array("response" => "created"));
		}

		app::abort(400);
	}



	public function getSkill(){
		
		if(Input::has('id')){
			
			$Skill = Skill::findOrFail($id)->toArray();
			
			return Response::json($Skill);
		}
		return Response::json(Skill::all());
	}

	public function deleteSkill(){
		
		if(Input::has('id')){
					
			Skill::findOrFail($id)->forceDelete();		
			return Response::json(array("deleted"));
		}

		app::abort(400);
	}

}
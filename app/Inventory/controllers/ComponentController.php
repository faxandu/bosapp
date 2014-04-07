<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Component, Inventory\models\Equipment, Response;

class ComponentController extends BaseController{
		
	public function postAdd(){
		$input = Input::all();
		$equipment_id = Equipment::where('serial_number', $input['serial_number']) -> pluck('id');
		$input[] = 'equipment_id' => $equipment_id;
		foreach($input as $key => $value){
			if(!$value) $input[$key] = NULL;
		}		
		try{
			if(!$input['equipment_id'] == NULL)
				$equipment_id = Equipment::findOrFail($input['equipment_id']);
			$component = Component::create($input);
			return Response::json(array('status' => 201, 'message' => 'created component'), 201);
		}
		catch(Exception $e){
			return Response::json(array('status' => 400, 'message' => 'failed to create component', 'error' => $e), 400);
		}
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
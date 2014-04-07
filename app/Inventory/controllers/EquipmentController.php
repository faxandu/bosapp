<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Equipment, Response;

class EquipmentController extends BaseController{
	
	public function postAdd(){
		$input = Input::all();
		foreach($input as $key => $value){
			if(!$value) $input[$key] = NULL;
		}
		try{
			$equipment = Equipment::create($input);
			return Response::json(array('status' => 201, 'message' => 'created equipment'), 201);
		}
		catch(Exception $e){
			return Response::json(array('status' => 400, 'message' => 'failed to create equipment', 'error' => $e), 400);
		}

	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
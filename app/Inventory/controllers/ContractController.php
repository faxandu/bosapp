<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Contract, Inventory\models\Equipment, Response;

class ContractController extends BaseController{

	public function addContract(){
		$input = Input::all();
		foreach($input as $key => $value){
			if(!$value) $input[$key] = NULL;
		}	
		try{
			$equipment_id = Equipment::findOrFail($input['equipment_id']);
			$component = Contract::create($input);
			return Response::json(array('status' => 201, 'message' => 'created contract'), 201);
		}
		catch(Exception $e){
			return Response::json(array('status' => 400, 'message' => 'failed to create contract', 'error' => $e), 400);
		}
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
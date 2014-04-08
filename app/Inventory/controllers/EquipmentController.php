<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Equipment, Response;

class EquipmentController extends BaseController{
	
	public function postAdd(){
		$input = Input::all();
		$validatedInput = Equipment::validate($input);
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

	public function postDelete($id){
		try{
			$equipment = Equipment::findOrFail($id);
			$equipment -> delete();
		catch{
			return Response::json(array('status' => 400, 'message' => 'equipment not found'), 400);
		}

		return Response::json(array('status' => 201, 'message' => 'equipment deleted'), 201);
	}

	public function postUpdate($id){
		$input = Input::all();
		$validatedInput = Equipment::validate($input);
		$messages = $validateInput -> messages();
		if(!$messages -> all()){
			try{
				$equipment = Equipment::findOrFail($id);
				$equipment -> update($validatedInput);
			}
			catch(Exception $e){
				return Response::json(array('status' => 400, 'messages' => 'equipment not updated', 'error' => $e), 400);
			}
		}
		else{
			return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $messages), 400);
		}
		return Response::json(array('status' => 201, 'messages' => 'equipment updated successfully'), 201);
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
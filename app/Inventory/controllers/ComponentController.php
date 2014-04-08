<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Exception, Inventory\models\Component, Inventory\models\Equipment, Response;

class ComponentController extends BaseController{
		
	public function postAdd(){
		$input = Input::all();
		$validatedInput = Course::validate($input);
		$messages = $validatedInput-> messages();
		$equipment_id = Equipment::where('serial_number', $input['serial_number']) -> pluck('id');
		$input['equipment_id'] = $equipment_id;	
		try{
			if(isset($input['serial_number']) && empty($equipment_id)){
				throw new Exception("no equipment with serial number");
			}
			$component = Component::create($input);
			return Response::json(array('status' => 201, 'message' => 'created component'), 201);
		}
		catch(Exception $e){
			return Response::json(array('status' => 400, 'message' => 'failed to create component', 'error' => $e), 400);
		}
	}

	public function postDelete($id){
		try{
			$component = Component::findOrFail($id);
			$component -> delete();
		catch(Exception $e){
			return Response::json(array('status' => 400, 'message' => 'component_not_found', 'error' => $e), 400);
		}

		return Response::json(array('status' => 201, 'message' => 'component deleted'), 201);
	}

	public function postUpdate($id){
		$input = Input::all();
		$validatedInput = Component::validate($input);
		$messages = $validateInput -> messages();
		if(!$messages -> all()){
			try{
				$component = Component::findOrFail($id);
				$component -> update($validatedInput);
			}
			catch(Exception $e){
				return Response::json(array('status' => 400, 'messages' => 'component not updated', 'error' => $e), 400);
			}
		}
		else{
			return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $messages), 400);
		}
		return Response::json(array('status' => 201, 'messages' => 'component updated successfully'), 201);
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
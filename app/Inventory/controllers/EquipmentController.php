<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Inventory\models\Equipment, Response, View;


class EquipmentController extends BaseController{
	
	public function postCreate(){
		$input = Input::all();
		$validate = Equipment::validate($input);
		if($validate -> fails()){
			return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $validate -> messages()), 400);
		}
		else{
			try{
				$equipment = Equipment::create($input);
				$this->layout->content = View::make('inventory.equipmentForm', array('status' => 201, 'message' => 'Equipment Added Successfully'));
				//return Response::json(array('status' => 201, 'message' => 'created equipment'), 201);
			}
			catch(Exception $e){
				$this->layout->content = View::make('inventory.equipmentForm', array('status' => 400, 'message' => 'Failed to add Eqipment', 'error' => $e));
				//return Response::json(array('status' => 400, 'message' => 'failed to create equipment', 'error' => $e), 400);

			}
		}
	}

	public function postDelete(){
		$id = Input::get('id');
		try{
			$equipment = Equipment::findOrFail($id);
			$equipment -> delete();
		}
		catch(Exception $e){
			return Response::json(array('status' => 400, 'message' => 'equipment not found', 'error' => $e), 400);
		}

		return Response::json(array('status' => 201, 'message' => 'equipment deleted'), 201);
	}

	public function postUpdate(){
		$input = Input::all();
		$id = $input::get('id');
		$validate = Equipment::validate($input);
		if($validate -> fails()){
			return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $validate -> messages()), 400);
		}
		else{
			try{
				$equipment = Equipment::findOrFail($id);
				$equipment -> update($input);
			}
			catch(Exception $e){
				return Response::json(array('status' => 400, 'messages' => 'equipment not updated', 'error' => $e), 400);
			}
		}
		return Response::json(array('status' => 201, 'messages' => 'equipment updated successfully'), 201);
	}

	public function getIndex(){
		//return Response::json(Equipment::all());
		$this->layout->content = View::make('inventory.home', array('equipment' => Equipment::all()));
	}

	public function getForm() {
		$this->layout->content = View::make('inventory.equipmentForm');

	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
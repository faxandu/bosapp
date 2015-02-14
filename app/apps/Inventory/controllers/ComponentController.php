<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Exception, Inventory\models\Component, Inventory\models\Equipment, Response, Redirect;


class ComponentController extends BaseController{
		
	public function postCreate(){
		$input = Input::all();
		$input['equipment_id'] = Equipment::where('id', $input['equipment_id']) -> pluck('id');
//		$validate = Component::validate($input);
//		if($validate -> fails()){
//			return Redirect::to('inventory/equipment')->with(array('status' => 400, 'message' => 'Component Form Validation Failed', 'error' => $validate -> messages()));
//		}
//		else{
			try{
				$component = Component::create($input);
				//return Response::json(array('status' => 201, 'message' => 'created component'), 201);
				return Redirect::to('inventory/equipment')->with(array('status' => 201, 'message' => 'Component Added Successfully'));
			}
			catch(Exception $e){
				//return Response::json(array('status' => 400, 'message' => 'failed to create component', 'error' => $e), 400);
				return Redirect::to('inventory/equipment')->with(array('status' => 400, 'message' => 'Failed to add Component', 'error' => $e));
			}
//		}
	}

	public function getDelete($id){
//		$input = Input::get('id');
		try{
			$component = Component::find($id);
			$component -> delete();
		}
		catch(Exception $e){
		return Redirect::back()->with('message', 'Component Not Found')->with('alert', 'danger');
		}
		return Redirect::back()->with('message', 'Component Deleted')->with('alert', 'success');
//		return Response::json(array('status' => 201, 'message' => 'component deleted'), 201);
	}

	public function postUpdate(){
		$input = Input::all();
		$id = Input::get('id');
		$validate = Component::validate($input);
		if($validate -> fails()){
			return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $validate -> messages()), 400);
		}
		else{
			try{
				$component = Component::findOrFail($id);
				$component -> update($input);
			}
			catch(Exception $e){
				return Response::json(array('status' => 400, 'messages' => 'component not updated', 'error' => $e), 400);
			}
		}
		return Response::json(array('status' => 201, 'messages' => 'component updated successfully'), 201);
	}

	public function getData(){
		return Response::json(Component::all());
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

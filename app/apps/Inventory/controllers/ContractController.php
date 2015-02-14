<?php

namespace Inventory\controllers;
use BaseController, Input, User, Entry, Exception, Inventory\models\Contract, Inventory\models\Equipment, Response, Redirect;


class ContractController extends BaseController{

	public function postCreate(){
		$input = Input::all();
		$input['equipment_id'] = Equipment::where('id', $input['equipment_id']) -> pluck('id');
//		$validate = Contract::validate($input);
//		if($validate -> fails()){
//			//return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $validate -> messages()), 400);
//			return Redirect::to('inventory/equipment')->with(array('status' => 400, 'message' => 'Service Contract Form Validation Failed', 'error' => $validate -> messages()));
//		}
//		else{
			try{
				$contract = Contract::create($input);
				//return Response::json(array('status' => 201, 'message' => 'created contract'), 201);
				return Redirect::to('inventory/equipment')->with(array('status' => 201, 'message' => 'Service Contract Added Successfully'));
			}
			catch(Exception $e){
				return Redirect::to('inventory/equipment')->with(array('status' => 400, 'message' => 'Failed to add Service Contract', 'error' => $e));
			}
//		}
	}

	public function getDelete($id){
//		$id = Input::get('id');
		try{
			$contract = Contract::find($id);
			$contract -> delete();
		}
		catch(Exception $e){
	                return Redirect::back()->with('message', 'Contract Not Found')->with('alert', 'danger');
		}
                return Redirect::back()->with('message', 'Contract Deleted')->with('alert', 'success');
	}

	public function postUpdate(){
		$input = Input::all();
		$id = Input::get('id');
		$validate = Contract::validate($input);
		if($validate -> fails()){
			return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $validate -> messages()), 400);
		}
		else{
			try{
				$contract = Contract::findOrFail($id);
				$contract -> update($input);
			}
			catch(Exception $e){
				return Response::json(array('status' => 400, 'messages' => 'contract not updated', 'error' => $e), 400);
			}
		}
		return Response::json(array('status' => 201, 'messages' => 'contract updated successfully'), 201);
	}

	public function getData(){
		return Response::json(Contract::all());
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

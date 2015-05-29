<?php
//return Response::json(array('status' => 400, 'messages' => 'input validation failed', 'error' => $validate -> messages()), 400);
namespace Inventory\controllers;
use BaseController, Input, User, Entry,  Inventory\models\Contract, Inventory\models\Component, Inventory\models\Equipment, Response, Redirect, View, Excel;


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

	public function getDelete($id){
		try{
			$equipment = Equipment::find($id);
			$contracts = Contract::where('equipment_id', '=', $id);
				foreach ($contracts as $i){
				$i -> delete();
			}
			$componets = Component::where('equipment_id', '=', $id);
			foreach ($componets as $i){
				$i -> delete();
			}
			$equipment -> delete();
			
		}
		catch(Exception $e){
			return Redirect::back()->with('message', 'Entry Not Found')->with('alert', 'danger');
		}

		return Redirect::back()->with('message', 'Entry Deleted')->with('alert', 'success');
	}

	public function postUpdate(){
		$input = Input::all();
		$id = Input::get('id');
		$validate = Equipment::validate($input);
		if($validate -> fails()){
			return Redirect::back()->with('message', 'Input Error')->with('alert', 'danger');
		}
		else{
			try{
				$equipment = Equipment::findOrFail($id);
				$equipment -> update($input);
			}
			catch(Exception $e){
				return Redirect::back()->with('message', 'Equipment not Found')->with('alert', 'danger');
			}
		}
		return Redirect::back()->with('message', 'Entry Update')->with('alert', 'sucess');
	}

	public function getIndex(){
		//return Response::json(Equipment::all());
		$this->layout->content = View::make('inventory.home', array('equipment' => Equipment::all()));
	}

	public function getForm() {
		$this->layout->content = View::make('inventory.equipmentForm');

	}

	public function getReport()
	{
		$queryComp = Equipment::Where('type', '=', 'computer')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$queryRout = Equipment::Where('type', '=', 'router')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$querySwit = Equipment::Where('type', '=', 'switch')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$queryServ = Equipment::Where('type', '=', 'server')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$queryFire = Equipment::Where('type', '=', 'firewall')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();

		$title = "Inventory_Report_" . date('Y-m-d');

		Excel::create($title, function($excel) use ($queryComp, $queryRout, $querySwit, $queryServ, $queryFire) {
			$excel->sheet('Computers', function($sheet) use ($queryComp){
				$sheet->fromArray($queryComp);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Routers', function($sheet) use ($queryRout){
				$sheet->fromArray($queryRout);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Switches', function($sheet) use ($querySwit){
				$sheet->fromArray($querySwit);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Servers', function($sheet) use ($queryServ){
				$sheet->fromArray($queryServ);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Firewalls', function($sheet) use ($queryFire){
				$sheet->fromArray($queryFire);
				$sheet->setAutoSize(true);
			});
		})->export('xls');	
	}

	public function getWithContract()
	{
		//$query = Contract::join('inventory_equipment', 'inventory_contract.equipment_id', '=', 'inventory_equipment.id')->select('inventory_equipment.*')->get();
		$query = Equipment::join('inventory_contract', 'inventory_equipment.id', '=', 'inventory_contract.equipment_id')->select('inventory_equipment.*')->distinct()->get();
		//$query = Equipment::all();
		$this->layout->content = View::make('inventory.home', array('equipment' => $query));
		//return Response::json($query);
	}

	public function missingMethod($parameters = array())
	{
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}

	public function getReportContract()
	{
		$queryComp = Equipment::join('inventory_contract', 'inventory_equipment.id', '=', 'inventory_contract.equipment_id')->Where('inventory_equipment.type', '=', 'computer')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$queryRout = Equipment::join('inventory_contract', 'inventory_equipment.id', '=', 'inventory_contract.equipment_id')->Where('inventory_equipment.type', '=', 'router')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$querySwit = Equipment::join('inventory_contract', 'inventory_equipment.id', '=', 'inventory_contract.equipment_id')->Where('inventory_equipment.type', '=', 'switch')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$queryServ = Equipment::join('inventory_contract', 'inventory_equipment.id', '=', 'inventory_contract.equipment_id')->Where('inventory_equipment.type', '=', 'server')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
		$queryFire = Equipment::join('inventory_contract', 'inventory_equipment.id', '=', 'inventory_contract.equipment_id')->Where('inventory_equipment.type', '=', 'firewall')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();



//		$queryRout = Equipment::Where('type', '=', 'router')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
//		$querySwit = Equipment::Where('type', '=', 'switch')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
//		$queryServ = Equipment::Where('type', '=', 'server')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();
//		$queryFire = Equipment::Where('type', '=', 'firewall')->OrderBy('location')->OrderBy('manufacturer')->OrderBy('model')->get();

		$title = "Inventory_Report_Contracts_" . date('Y-m-d');

		Excel::create($title, function($excel) use ($queryComp, $queryRout, $querySwit, $queryServ, $queryFire) {
			$excel->sheet('Computers', function($sheet) use ($queryComp){
				$sheet->fromArray($queryComp);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Routers', function($sheet) use ($queryRout){
				$sheet->fromArray($queryRout);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Switches', function($sheet) use ($querySwit){
				$sheet->fromArray($querySwit);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Servers', function($sheet) use ($queryServ){
				$sheet->fromArray($queryServ);
				$sheet->setAutoSize(true);
			});
			$excel->sheet('Firewalls', function($sheet) use ($queryFire){
				$sheet->fromArray($queryFire);
				$sheet->setAutoSize(true);
			});
		})->export('xls');	
	}
	
	public function getFileadd()
	{

	}

}

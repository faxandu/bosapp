<?php

namespace GroupStudy\controllers;
use BaseController, Input, Excel, User, Response, GroupStudy\models\Entry, GroupStudy\models\Student, View;

class ReportController extends BaseController
{

	public function getIndex() {

		$this->layout->content = View::make('admin/study/display', array('entries' => Entry::all()));

	}

	// public function getHello(){

	// 	// try{
	//  // 		$entry = Entry::whereNull('end_time')->where('facilitator', Auth::user()->id)->get();
	//  // 	}
	//  // 	catch(Exception $e){
	//  // 		//return Response::json(array('status' => 'error'));

	// 	// }

	// 	// return Response::json(array('entry' => $entry));
	// 	//$this->layout->content = View::make('study/monitor', array('students' => $entry));
	//     $test = 'alsdkjfladsfj';
	// 	return View::make('hello', array('hello' => $test));

	// }

	public function getReport()
	{
		$input = Input::all();
		$date = $input['year'] . "-" . $input['month'] . "-" . $input['day'];
		$report;

		switch($input['type']){
			case 'date':
				$report = $this -> getDateReport($date);
				break;
			case 'class':
				$report = $this -> getClassReport($input['class']);
				break;
			case 'student_id':
				$report = $this -> getStudentIdReport($input['student_id']);
				break;
		}
		return $report;
	}

	public function getDateReport($date)
	{
		$report = Entry::join('user', 'entry.user_id', '=', 'user.id') -> where('date', $date) 
							->  select('user.name', 'user.student_id', 'entry.class', 'entry.date', 'entry.start_time', 'entry.end_time') -> get();
		return $report;
	}

	public function getClassReport($class)
	{
		$report = Entry::join('user', 'entry.user_id', '=', 'user.id') -> where('entry.class', $class) 
							->  select('user.name', 'user.student_id', 'entry.class', 'entry.date', 'entry.start_time', 'entry.end_time') -> get();
		return $report;
	}

	public function getStudentIdReport($student_id)
	{
		$report = Entry::join('user', 'entry.user_id', '=', 'user.id') -> where('user.student_id', $student_id) 
							->  select('user.name', 'user.student_id', 'entry.class', 'entry.date', 'entry.start_time', 'entry.end_time') -> get();
		//$report = DB::table('entry') -> where('student_id', $student_id) -> get();
		return $report;
	}

	public function getExcelExport(){
		Excel::create('Group_Study_Report', function($excel){
			$excel->sheet('test', function($sheet){
				$sheet->fromArray(Entry::all());
			});
		})->export('xls');

		// Excel::create('Group_Study_Report', function($excel){
		// 	$excel->sheet($input['type'], function($sheet){
		// 		$sheet->fromArray($report);
		// 	});
		// })->export('xls');
	}

	public function missingMethod($parameters = array())
	{
	    
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
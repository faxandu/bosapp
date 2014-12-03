<?php

namespace GroupStudy\controllers;
use BaseController, Input, Excel, User, Response, GroupStudy\models\Entry, GroupStudy\models\Student, View;

class ReportController extends BaseController
{

	public function getIndex() {
		$this->layout->content = View::make('admin/study/display', array('entries' => Entry::all()));
	}

	public function getReport(){
		$input = Input::all();
		$query = Entry::join('group_study_student', 'group_study_entry.student_id', '=', 'group_study_student.id')
						-> join('user', 'group_study_entry.facilitator', '=', 'user.id') 
						-> select('group_study_entry.date', 'group_study_student.first_name as student_first_name', 'group_study_student.last_name as student_last_name', 'group_study_entry.class', 
									'group_study_entry.start_time', 'group_study_entry.end_time', 'user.first_name', 'user.last_name');
		switch($input['type']){
			case 'date':
				$data = $this -> getDateReport($input['start_date'], $input['end_date'], $query);
				break;
			case 'class':
				$data = $this -> getClassReport($input['class'], $input['start_date'], $input['end_date'], $query);
				break;
			case 'student':
				$data = $this -> getStudentIdReport( $input['student_id'], $input['start_date'], $input['end_date'], $query);
				break;
		}
		$this -> getExcelExport($data);

	}

	public function getDateReport($start_date, $end_date, $query){
		$data = $query -> where('group_study_entry.date', '>=', $start_date)->where('group_study_entry.date', '<=', $end_date)
						->orderBy('group_study_entry.date', 'asc')->get();
		return $data;
	}

	public function getClassReport($class, $start_date, $end_date, $query){
		$data = $query -> where('group_study_entry.class', '=', $class) -> where('group_study_entry.date', '>=', $start_date)->where('group_study_entry.date', '<=', $end_date)
						->orderBy('group_study_entry.date', 'asc')->get();
		return $data;
	}

	public function getStudentIdReport($student_id, $start_date, $end_date, $query){
		$data = $query -> where('group_study_student.student_num', '=', $student_id) -> where('group_study_entry.date', '>=', $start_date)->where('group_study_entry.date', '<=', $end_date)
						->orderBy('group_study_entry.date', 'asc')->get();
		return $data;
	}

	public function getExcelExport($report){
		$data = $report;
		Excel::create('Group_Study_Report', function($excel) use ($data){
			$excel->sheet('test', function($sheet) use($data){
				$sheet->fromArray($data);
				$sheet->mergeCells('B1:C1');
				$sheet->mergeCellS('G1:H1');
				$sheet->row(1, array('Date', 'Student Name', '', 'Course Number', 'Time In', 'Time Out', 'Facilitator Name'));
				$sheet->setAutoSize(true);
			});
		})->export('xls');

		// Excel::create('Group_Study_Report', function($excel){
		// 	$excel->sheet($input['type'], function($sheet){
		// 		$sheet->fromArray($report);
		// 	});
		// })->export('xls');
	}

	public function missingMethod($parameters = array()){	    
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
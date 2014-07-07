<?php

namespace GroupStudy\controllers;
use BaseController, Input, User, Entry, GroupStudy\models\Student, Response;

class EntryController extends BaseController{

	/**
	 * postStudentExists
	 * Checks if user exists, if not, calls add_student() and adds the student to the database.
	 * @param  none
	 * @return returns json response with error or added entry
	 */
	public function postStudentExists(){
	 	$student_num = substr(Input::get('student_num'), 2, 8);   //used to grab only the student number from the id card.
	 	$class = Input::get('class');
	 	$student = Student::where('student_num', $student_num) -> get();  
		if(empty($student['id'])) 
			return Response::json(array('status' => 'student_does_not_exist', 'student_num' => $student_num, 'class' => $class));
	 	else
	 		return $this -> checkPunchedIn($student_id);
	 }

	/**
	 * checkPunchedIn
	 * Checks if user exists, if not, calls add_student() and adds the student to the database.
	 * @param  none
	 * @return returns json response with successful timestamp for start or end time, or error if it occurs
	 */
	 public function checkPunchedIn($student_id){
	 	//$entry_id = Entry::where('student_id', $student_id) -> where('date', $date) ->    //checks if a start_time has been created for the user
		//		whereNotNull('start_time') -> whereNull('end_time') -> pluck('id');		  //if not, goes to start_entry, else goes to end_entry
	 	$start_date = date('Y-m-d');
	 	$entry = Entry::leftjoin('group_study_student_entry', 'group_study_student.id', '=', 'group_study_entry.student_id')
	 				->where('group_study_student.id', $student_id) -> where('start_date', $start_date) 
	 				->whereNotNull('start_time')-> get();
		if(empty($entry))
			 return $this -> start_entry($student_id, $class);
		else
			 return $this -> end_entry($entry_id);
		}

	/**
	 * postAddStudent
	 * Adds the user to the student database and calls start_entry to create an entry and update the start_time timestamp.
	 * @param  none
	 * @return returns json response if user is created or if error occurs
	 */
<<<<<<< HEAD
	public function postAddStudent($student_num, $class){
=======
	 public function postAddStudent($student_num, $class){
>>>>>>> 60f1aa33f7cdff914b791f1e833d13ec68ac093d
	 	$input = Input::all();
	 	$student_arr = array('first_name' => $input['first_name'], 'last_name' => $input['last_name'], 
	 					'student_num' => $student_num);
	 	try{
	 		$student = Student::create($student_arr);
		}
	 	catch(Exception $e){
	 		return Response::json(array('status' => 'user_not_created'));
	 	}
	 	return $this -> start_entry($student['id'], $class);
	 }

	/**
	 * postStartEntry
	 * Adds a entry into the entry database and add a start_time timestamp.
	 * @param (int)$student_id: pk for student db, (string)$class, (date) $date: current date
	 * @return json response to add_student that returns the entry created or not created.
	 */
	public function postStartEntry($student_id, $class){
		$start_date = date('Y-m-d');
		$entry_arr = array(
				'class' => $class,
				'date' => $start_date
				);
		try{
			$entry = Entry::create($entry_arr);
			$entry -> update(array('start_time' => date('H:m:s')));
		}
		catch(Exception $e){
			return Response::json(array('status' => 'entry_not_created'));
		}
		return Response::json(array('status' => 'created_in_time'));
	}

<<<<<<< HEAD

	/**
	 * postEndEntry
	 * Updates an entry to have an end_time entry.
	 * @param (int)$student_id: pk for student db, (string)$class, (date) $date: current date
	 * @return json response to add_student that returns the entry created or not created.
	 */
=======
>>>>>>> 60f1aa33f7cdff914b791f1e833d13ec68ac093d
	public function postEndEntry($entry_id, $date){
		if(empty($entry_id))
			return Response::json(array('status' => 'entry_not_found'));
		try{
			Entry::where('id', $entry_id) -> update(array('end_time' => date('H:m:s')));  
		}
		catch(Exception $e){
			return Response::json(array('status' => 'out_time_not_created'));
		}
		return Response::json(array('status' => 'created_out_time'));
	}

	/**
	 * postDeleteEntry
	 * Checks for entry by PK.  If found, deletes the entry.
	 * @param (int) ($id) PK for entry.
	 * @return (PK) (id) returns json response for error or success
	 */
	public function postDeleteEntry($id){
		$entry = Entry::find($id);
		if(empty($entry)) 
			return Response::json(array('status' => 'entry_not_found'));
		try{
			$entry -> delete();
		}
		catch(Exception $e){
			return Response::json(array('status' => 'entry_not_deleted'));
		}
		return Response::json(array('status' => 'deleted_entry'));
	}

	/**
	 * postUpdateEntry
	 * Check for entry by Pk.  If found, allows for updating of certain fields.
	 * @param (int) ($id) PK for entry.
	 * @return (PK) (id) returns json response for error or success
	 */
	public function postUpdateEntry($id){
		$input = Input::all();
		$entry = Entry::find($id);
		if(empty($entry))
			return Response::json(array('status' => 'entry_not found'));
		else{

		}
	}

	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}


	 // public function bob(){
	 // 	$student_num = 383838;
	 // 	$student = Student::where('student_num', $student_num) -> get();
		// return $student[0]['id'];
	 // }

	 // public function bob2(){
	 // 	$entry = Entry::find(1);
	 // 	return $entry-> student;
	 // }

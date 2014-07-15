<?php

namespace GroupStudy\controllers;

use BaseController, Input, Exception, User, GroupStudy\models\Entry, GroupStudy\models\Student, Response, Redirect, View;


class EntryController extends BaseController{

	/**
	 * postStudentExists
	 * Checks if user exists, if not, calls add_student() and adds the student to the database.
	 * @param  none
	 * @return returns json response with error or added entry
	 */

	 // public function postStudentExists(){
	 // 	$student_num = substr(Input::get('student_num'), 2, 8);   //used to grab only the student number from the id card.
	 // 	$class = Input::get('class');
	 // 	$date = date('Y-m-d');
	 // 	$student_id = Student::where('student_num', $student_num) -> pluck('id');  
		// if(empty($student_id)) 
		// 	return Response::json(array('error' => 'user_does_not_exist', 'student_num' => $student_num, 'class' => $class));
	 // 	else{
	 // 		$entry_id = Entry::where('student_id', $student_id) -> where('date', $date) ->    //checks if a start_time has been created for the user
		// 			whereNotNull('start_time') -> whereNull('end_time') -> pluck('id');		  //if not, goes to start_entry, else goes to end_entry
		// 	if(empty($entry_id))
		// 		return $this -> start_entry($student_id, $class, $date);
		// 	else
		// 		return $this -> end_entry($entry_id, $date);
	 // 	}
	 // }

	public function postStudentExists(){
	 	$student_num = substr(Input::get('student_num'), 2, 8);   //used to grab only the student number from the id card.
	 	$class = Input::get('class');
	 	try{
	 		$student = Student::where('student_num', '=', $student_num) -> firstOrFail();
	 		return $this -> checkPunchedIn($student, $class);
	 	}
	 	catch(Exception $e){
			//return Response::json(array('status' => 'student_does_not_exist', 'student_num' => $student_num, 'class' => $class));
			$this->layout->content = View::make('study/new', array('student_num' => $student_num, 'class' => $class));

		}
		
	 }

	/**
	 * checkPunchedIn
	 * Checks if user exists, if not, calls add_student() and adds the student to the database.
	 * @param  none
	 * @return returns json response with successful timestamp for start or end time, or error if it occurs
	 */
	 public function checkPunchedIn($student, $class){
	 	//$entry_id = Entry::where('student_id', $student_id) -> where('date', $date) ->    //checks if a start_time has been created for the user
		//		whereNotNull('start_time') -> whereNull('end_time') -> pluck('id');		  //if not, goes to start_entry, else goes to end_entry
	 	$start_date = date('Y-m-d');
	 	try{
	 		$entry = Entry::where('student_id', $student->id) -> where('date', $start_date) 
	 				->whereNull('end_time')-> firstOrFail();
	 	}
	 	catch(Exception $e){
			 return $this -> postStartentry($student, $class);
		}
		return $this -> postEndEntry($entry->id);
		}

	/**
	 * postAddStudent
	 * Adds the user to the student database and calls start_entry to create an entry and update the start_time timestamp.
	 * @param  none
	 * @return returns json response if user is created or if error occurs
	 */
	 public function postAddStudent(){
	 	$input = Input::all();
	 	$student_arr = array('first_name' => $input['first_name'], 'last_name' => $input['last_name'], 

	 					'student_num' => $input['student_num']);
	 	try{
	 		$student = Student::create($student_arr);
		}
	 	catch(Exception $e){
	 		return Response::json(array('status' => 'user_not_created'));

	 	}
	 	return $this -> postStartEntry($student, $input['class']);
	 }

	/**
	 * postStartEntry
	 * Adds a entry into the entry database and add a start_time timestamp.
	 * @param (int)$student_id: pk for student db, (string)$class, (date) $date: current date
	 * @return json response to add_student that returns the entry created or not created.
	 */
	public function postStartEntry($student, $class){
		$entry_arr = array(
				'student_id' => $student->id,
				'class' => $class,
				'date' => date("Y-m-d"),
				'start_time' => date('H:m:s')
				);
		try{
			$entry = Entry::create($entry_arr);
			$this->layout->content = View::make('study/checkin', array('student' => $student));
		}
		catch(Exception $e){
			//return Response::json(array('status' => 'entry_not_created', 'error' => $e));
			$this->layout->content =  Redirect::to('/group_study')->with(array('message' => 'You must select a class', 'alert' => 'warning'));
		}
		//return Response::json(array('status' => 'created_in_time'));

	}


	/**
	 * postEndEntry
	 * Updates an entry to have an end_time entry.
	 * @param (int)$student_id: pk for student db, (string)$class, (date) $date: current date
	 * @return json response to add_student that returns the entry created or not created.
	 */
	public function postEndEntry($entry_id){
		if(empty($entry_id))
			return Response::json(array('status' => 'entry_not_found'));
		try{
			Entry::where('id', $entry_id) -> update(array('end_time' => date('H:m:s')));  
			$this->layout->content = View::make('study/checkout');
		}
		catch(Exception $e){
			//return Response::json(array('status' => 'out_time_not_created'));
			$this->layout->content = Redirect::to('/group_study')->with(array('message' => 'Failed to sign you out. Please try again', 'alert' => 'warning'));
		}
		//return Response::json(array('status' => 'created_out_time'));
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

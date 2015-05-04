<?php
//
namespace GroupStudy\controllers;

use BaseController, Input, Exception, User, GroupStudy\models\Entry, GroupStudy\models\Student, Response, Redirect, View;

use Illuminate\Support\Facades\Auth;

class EntryController extends BaseController{


	/**
	 * postStudentExists
	 * Checks if user exists, if not, calls add_student() and adds the student to the database.
	 * @param  none
	 * @return returns json response with error or added entry
	 */
	public function postStudentExists(){
		$test = 0;
	 	$student_num = preg_replace("/^.*@([0-9]{8}).*$/", "\\1", Input::get('student_num'), -1, $test);   //used to grab only the student number from the id card. //replaced statement with some regex

		if (!$test){
			return Redirect::back()->with('message', 'ID Not Valid')->with('alert', 'danger');
		}
	 	$class = Input::get('class');
	 	try{
	 		$student = Student::where('student_num', '=', $student_num) -> firstOrFail();
	 		return $this -> checkPunchedIn($student, $class);
	 	}
	 	catch(Exception $e){
			$this->layout->content = View::make('study/new', array('student_num' => $student_num, 'class' => $class));
		}	
	 }

	public function postManualCreate(){
	 	$student_num = Input::get('student_num');
	 	if(substr($student_num, 0, 1) == '@')
	 		$student_num = substr($student_num, 1, 9);

	 	$class = str_replace(' ', '', strtoupper(Input::get('class')));

		if (strlen($class) < 6)
			return Redirect::back()->with('message', 'Manual Entries still require a Class')->with('alert', 'danger');

	 	if(strlen($student_num) == 8){
		 	try{
		 		$student = Student::where('student_num', '=', $student_num) -> firstOrFail();
		 		return $this -> checkPunchedIn($student, $class);
		 	}
		 	catch(Exception $e){
				$this->layout->content = View::make('study/new', array('student_num' => $student_num, 'class' => $class));
			}
		}
		else
			$this->layout->content =  Redirect::to('/group_study')->with(array('message' => 'Please make sure the student ID contains 8 digits', 'alert' => 'warning'));
	 }


	/**
	 * checkPunchedIn
	 * Checks if user exists, if not, calls add_student() and adds the student to the database.
	 * @param  none
	 * @return returns json response with successful timestamp for start or end time, or error if it occurs
	 */
	 public function checkPunchedIn($student, $class){
	 	$date = date('Y-m-d');
	 	try{
	 		$entry = Entry::where('student_id', $student->id) -> where('date', $date) ->whereNull('end_time')-> firstOrFail();
	 		return $this -> postEndEntry($entry->id);
	 	}
	 	catch(Exception $e){
			 return $this -> postStartentry($student, $class);
		}
	}

	/**
	 * postAddStudent
	 * Adds the user to the student database and calls start_entry to create an entry and update the start_time timestamp.
	 * @param  none
	 * @return returns json response if user is created or if error occurs
	 */
	 public function postAddStudent(){
	 	$input = Input::all();
	 	$student_arr = array('first_name' => $input['first_name'], 'last_name' => $input['last_name'], 'student_num' => $input['student_num']);
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
				'start_time' => date('H:i:s'),
				'facilitator' => Auth::user()->id
				);
		try{
			$entry = Entry::create($entry_arr);
			$this->layout->content = View::make('study/checkin', array('student' => $student));
		}
		catch(Exception $e){
			$this->layout->content =  Redirect::to('/group_study')->with(array('message' => 'You must select a class', 'alert' => 'warning'));
		}
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
			Entry::where('id', $entry_id) -> update(array('end_time' => date('H:i:s')));  
			$this->layout->content = View::make('study/checkout');
		}
		catch(Exception $e){
			$this->layout->content = Redirect::to('/group_study')->with(array('message' => 'Failed to sign you out. Please try again', 'alert' => 'warning'));
		}
	}

	/**
	 * postDeleteEntry
	 * Checks for entry by PK.  If found, deletes the entry.
	 * @param (int) ($id) PK for entry.
	 * @return (PK) (id) returns json response for error or success
	 and shit */
	public function getDeleteEntry($id){
		$entry = Entry::find($id);
		if(empty($entry)) 
			return Response::json(array('status' => 'entry_not_found'));
		try{
		        if ($entry['facilitator'] != Auth::user()->id) {
			          return Response::json(array('status' => 401, 'message' => 'You can only delete your own Entrys'), 401);
		        }
			$entry -> delete();
		}
		catch(Exception $e){
			return Response::json(array('status' => 'error, entry_not_deleted'));
		}
		return Redirect::back()->with('message', 'Entry Deleted')->with('alert', 'success');
	}

	public function getMonitor(){
		try{
	 		$entry = Entry::whereNull('end_time')->where('facilitator', Auth::user()->id)->get();
	 	}
	 	catch(Exception $e){
		}
		$this->layout->content = View::make('study/monitor', array('students' => $entry));
	}

	public function getSetEndTime($entry_id){
		try{
			Entry::where('id', $entry_id) -> update(array('end_time' => date('H:m:s'))); 
			return Redirect::to('group_study/entry/monitor')->with('message', 'Student Logged Out')->with('alert', 'success');
		}
		catch(Exception $e){
			return Redirect::to('group_study/entry/monitor')->with('message', 'Failed to sign out user')->with('alert', 'warning');
		}
	}

	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}



	/*-----------jason addition to code
	*
	*  getHistory is a page wherein facilitators can check previous enterys (the last 20)
	*  and change them in case of errors for the time, it returns all enterys for a given facilitator
	*still need to have it show names instead of ID nums
	*
	*  postModify is for, well, modifying enteries.
	*
	*/

	public function getHistory(){

//	$entry = "hello"; //----------------------------------------------------------------------
//	$this->layout->content = View::make('study/history', array('ent' => $entry));

	$entry = Entry::where('facilitator', Auth::user()->id)->orderby('id', 'DESC')->take(20)->get();
	foreach ( $entry as $i ) { $i->student_name = Student::find($i->student_id); }
	$this->layout->content = View::make('study/history', array('ent' => $entry));

	}


	public function postModify(){
	
		$target = Entry::find(Input::get('id'));
		
		$target->start_time = Input::get('start_time');
		$target->end_time = Input::get('end_time');
		$target->date = Input::get('date');
		$target->class = Input::get('class');
	
		try{
		    $target->save();
		    return Redirect::back()->with('message', 'Entry Modified')->with('alert', 'success');
		}catch (exception $e){
		    return Redirect::back()->with('message', 'Modify Failed')->with('alert', 'danger');
		}
	
	} //end of Modify funtion

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

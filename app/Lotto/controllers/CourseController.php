<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Course, Lotto\models\Skill, User;
use Input, Response, Exception;
use View;

class CourseController extends BaseController {

	public function getHome(){
		$this->layout->content = View::make('lotto.home');
	}

	public function getCreate(){
		$this->layout->content = View::make('lotto.course.courseCreate')->nest('courseForm', 'lotto.course.courseForm');
	}

	public function postCreate(){

		$input = Input::all();
		$validatedInput = Course::validate(Input::all());
		$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		if(!$messages->all()){
			try{

				$course = Course::create($input);

				$this->layout->content = View::make('lotto.course.courseCreate')->nest('courseForm', 'lotto.course.courseForm', array('course' => $course));

			}catch(Exception $e){
				$this->layout->content = View::make('lotto.course.courseCreate')->nest('courseForm', 'lotto.course.courseForm')->with('error', $e);
			}
		}
		$this->layout->content = View::make('lotto.course.courseCreate')->nest('courseForm', 'lotto.course.courseForm')->with('error', $messages->all());
	}

	/**
	*	Grab the Json file from the link.
	*	Parse each part into a specific array with keys. 
	*	Format time and date.
	*	Try to find existing entry, if so update else create
	*	Look to see if any courses have been deleted.
	*/
	public function getImport(){
		
		$file = file_get_contents($_ENV['courseLinkTest']);
		$data = json_decode($file, true);

		$timeFormat = "H:i:s";
		$dateFormat = "Y-m-d";
		$newCourses = 0;
		$updatedCourses = 0;
		$canceledCourses = 0;

		foreach($data as  $value){
			
			$parsed = array(
				'credit_hours' => $value['CREDIT_HOURS'],
				'end_time' => date($timeFormat,strtotime($value['END_TIME'])),
				'building' => $value['BUILDING'],
				'term_code' => $value['TERM_CODE'],
				'crn' => $value['CRN'],
				'status_code' => $value['SSTS_CODE'],
				'days_of_week' => $value['DAYS'],
				'instructor' => $value['INSTRUCTOR'],
				'start_time' => date($timeFormat,strtotime($value['BEGIN_TIME'])),
				'start_date' => date($dateFormat,strtotime($value['START_DATE'])),
				'section' => $value['SECTION'],
				'course_number' => $value['COURSE_NUMBER'],
				'room_number' => $value['ROOM_NUMBER'],
				'subject_code' => $value['SUBJECT_CODE'],
				'course_title' => $value['COURSE_TITLE'],
				'part_of_term' => $value['PART_OF_TERM'],
				'end_date' => date($dateFormat,strtotime($value['END_DATE']))
			);

			try{

				$course = Course::where('crn', '=', $parsed['crn'])->firstOrFail();

				if($course->status_code == 'X'){
					$canceledCourses++;
					$course->delete();
				}
		
				if(!empty(array_diff_assoc($parsed, $course->toArray()))){
					$course->update($parsed);
					$updatedCourses++;
				}


			}catch(Exception $e){
				Course::create($parsed);
				$newCourses++;
			}
		}
		


		// foreach(Course::all() as $course){

		// 	if(!array_key_exists($course->crn, $data)){
		// 		$course->delete();
		// 	}
		// }

		$this->layout->content = View::make('lotto.course.importStatus',
		 array('created' => $newCourses, 
		 	'updated' => $updatedCourses, 
			'canceled' => $canceledCourses));
	}

	public function getAssignLabaides(){

		//grab course list based off course level. lower -> higher
		foreach(Course::all()->sortBy('course_number') as $course){
			echo $course->course_title;

			//for every course - grab all users that can cover it.
			// 		Required skills
			// 		and must be able to aide within the time

			$eligibleLabaides = User::where('type','=','labAide')->with('skills')
			->whereHas('skills', function($query) use ($course){
				$query->where('name', '=', $course->course_title);
			})->with('availability')->whereHas('availability', function($query) use($course){
				$query->where('start_time', '<=', $course->start_time);
				$query->where('end_time', '>=', $course->end_time);
				$query->where('start_date', '<=', $course->start_date);
				$query->where('end_date', '>=', $course->end_date);
			})->get();

			//debug - print all labaides per course;
			foreach($eligibleLabaides as $user){
				echo $user->username;
			}

			
			//if only one labaide - assign as labaide
			if( $eligibleLabaides->count() == 1){
				$course->labaides()->attach($eligibleLabaides->first());

				continue;
			}
			exit;

			//get skill count

			//if not equal lowest gets it. if some are equal on the lowest - rand



			/// if skill count is equal

			/// sort based on priority of class. Highest to lowest - first gets. If same then rand
			echo $course;

		}

		exit;
		// Staff all courses that are possible
		foreach(Course::all() as $course){
			// per course - grab the labaides that can staff it.
			$eligibleLabaides = User::where('type','=','labAide')->with('skills')
			->whereHas('skills', function($query) use ($course){
				$query->where('name', '=', $course->course_title);
			})->get();

			echo "<pre>";
			foreach($eligibleLabaides as $user){
				echo $user->username." can staff ".$course->course_title;
				echo "<br>";
			}
			echo "<br>";
			echo "</pre>";
		}
		return "failed";
	}


	public function postDelete(){
		
		$id = Input::get('id');
		
		try{
			$course = Course::findOrFail($id);
			$course->delete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete course.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Course Deleted'), 200);
	}

	public function getGet(){
		$this->layout->content = View::make('lotto.course.list')->withCourses(Course::all());		
	}

	public function postGet(){
		
		$id = Input::get('id');

		try{	
			$course = Course::findOrFail($id);
			$course->labaides->toArray();
			return Response::json($course->toArray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get course.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function postRemoveLabAide(){
		
		$userId = Input::get('user');
		$courseId = Input::get('course');

		try{		
			Course::findorFail($courseId)->labaides()->detatch($userId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove labAide.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'labAide removed'), 200);
	}


	public function postSetLabaide(){
		$courseId = Input::get('course');
		$userId = Input::get('user');
		
		try{

			$user = User::findorFail($userId);
			$course = Course::findorFail($courseId);
			
			if(Course::checkUser($user, $course)){
				$course->labaides()->attach($user);
			}

		}catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign labAide', 'error' => $e->getMessage()), 400);
		}
		
		return Response::json(array('status' => 201, 'message' => 'LabAide assigned'), 201);
	 }

	 	public function postUpdate(){

		$validatedInput = Course::updateValidate(Input::all());
		$messages = $validatedInput->messages();
		$id = Input::get('id');
		// if any error messages, don't update and return errors.
		if(!$messages->all()){

			try{	

				$course = Course::find($id);
				$course->update(Input::all());
				
			}catch(exception $e){
				return Response::json(array('status' => 400, 	
				'message' => 'Failed to update course.', 'error' => $e->getMessage()), 400);
			}	
		} else{
			return Response::json(array('status' => 400,
		 'message' => 'Failed to update course', 'error' => $messages->all() ), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'Course Updated'), 200);

	}

	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

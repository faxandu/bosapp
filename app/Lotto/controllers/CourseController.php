<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Course, Lotto\models\Skill, User;
use Input, Response, Redirect, Session, Exception;
use View;

class CourseController extends BaseController {

	/*	
		Deprecated
	---------------------*/
	public function postCreate(){

		$input = Input::all();
		$validatedInput = Course::validate(Input::all());
		$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		if(!$messages->all()){
			try{

				$course = Course::create($input);

				$this->layout->content = View::make('lotto.course.courseCreate')->nest(
					'courseForm', 'lotto.course.courseForm', array('course' => $course));

			}catch(Exception $e){
				$this->layout->content = View::make('lotto.course.courseCreate')->nest(
					'courseForm', 'lotto.course.courseForm')->with('error', $e);
			}
		}
		$this->layout->content = View::make('lotto.course.courseCreate')->nest(
			'courseForm', 'lotto.course.courseForm')->with('error', $messages->all());
	}

	/*
		Grabs a JSON file from an external source.
		Parse the JSOn into an array format
			-format the time and dates.
		For each object try to create, update.
		Keep count along the way of create, update, or canceled courses.
		Return results.
	------------------------- */
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
			
				if(!empty(array_diff_assoc($parsed, $course->toArray()))){
					$course->update($parsed);
					$updatedCourses++;
				}

				if($course->status_code == 'X'){
					$canceledCourses++;
					//$course->delete();
				}

			}catch(Exception $e){
				Course::create($parsed);
				$newCourses++;
			}
		}


		return Redirect::to('admin/schedule/course/all')->with( 
			array('status' => 200, 
			'message' => 'Courses Imported Successfully',
			'created' => $newCourses, 
		 	'updated' => $updatedCourses, 
			'canceled' => $canceledCourses));
	}


	/*
		Get all the courses.
			-sort by the course number (lower number higher the priority).


				-- For every user that is a labaide
					- check to see if they have the skills of the current course
					- also check to see that their availability would work for the course.

					* then get those users.

				--if only one user
					- assign them as the labaide and move onto the next course
					<-
				--get the number of skills each user has.
					-assign to the labaide with the lowest # of skills.
					-if same # then rand pick

				-- if all have same number sort



	------------------------- */
	public function getAssignLabaides(){

		//grab course list based off course level. lower -> higher
		foreach(Course::all()->sortBy('course_number') as $course){

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

			if($eligibleLabaides->count() == 0){
				continue;
			}
						
			//if only one labaide - assign as labaide
			if( $eligibleLabaides->count() == 1){
				$course->labaides()->attach($eligibleLabaides->first()->id);

				continue;
			}

			//sort by skill count
			$eligibleLabaides->sortBy(function($user){
				return $user->skills->count();
			});
			
			//if not equal lowest gets it. if some are equal on the lowest - rand
			// get all labaides with the same lowest skill count
			$assignList = $eligibleLabaides->filter(function($user) use($eligibleLabaides){
				if($user->skills->count() == $eligibleLabaides->first()->skills->count()){
					return $user;
				}

			});

			//if only one - assign as labaide
			if($assignList->count() == 1){
				$course->labaides()->attach($assignList->first()->id);

				continue;
			}else if($eligibleLabaides->count() == $assignList->count()){
				echo $eligibleLabaides->count();
				print_r($assignList);
				exit;
				$course->labaides()->attach($assignList->get(rand(0, $eligibleLabaides->count()-1))->id);

				continue;
			}

			///////////////////////////////////// MAY NEED WORK

			/// if skill count is equal
			// $eligibleLabaides->sortBy(function($user){
			// 	$skills = $user->skills;
			// 	$priority = 0;
			// 	foreach($skills as $skill){
			// 		$priority += $skill
			// 	}
			// 	return $user->skills->count();
			// });

			/// sort based on priority of class. Highest to lowest - first gets. If same then rand
			$course->labaides()->attach($assignList->get(rand(0, $eligibleLabaides->count()-1)));

		}

		$this->layout->content = Redirect::to('admin/schedule/user/all');	
	}

	/*	Admin: deletes a course.
		Grab a course and delete it,
		then redirect to the listing page. 
	--------------- */
	public function postDelete(){
		
		$id = Input::get('id');
		
		try{

			$course = Course::findOrFail($id);
			$course->delete();

		}catch(exception $e){

			return Redirect::to('admin/schedule/course/all')
			->with(array('status' => 400, 'message' => 'Failed to Delete Course', 'error' => $e));
			
		}

		return Redirect::to('admin/schedule/course/all')
		->with(array('status' => 200, 'message' => 'Course Deleted Successfully'));
	}


	/* Admin: Get all courses
	------------ */
	public function getAll(){
		$this->layout->content = View::make('admin.lotto.courseList', array (
			'courses' => Course::all()), Session::all());		
	}

	/* Removes a user as a labaide from a course.
	------------------ */
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

<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Course, Lotto\models\Skill, User;
use Input, Response, Redirect, Session, Exception;
use View;

class AdminController extends BaseController {


	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/


	/*
		
		schedule management - home page

		list all courses and aides with course.

	*/
	public function getHome(){

		$this->layout->content = View::make('admin.lotto.home', array (
				 	'courses' => Course::all()->sortBy('user.id')), Session::all()
			 );
	
	}

	/*
		
		schedule management - home page

		list all labaides. 

	*/
	public function getUserList(){

		$users = User::where('type','=','labAide')->get();

		$this->layout->content = View::make('admin.lotto.userList')->with(array(
			'users' => $users
		));
	}

	public function getManualAssign(){


		try{

			$course = Course::find(input::get('id'));
			
			// get all labaides that have skills of the course, that are not the current labaide
			$labaides = User::labAides()->hasSkill($course)->availableToLabaide($course)->where(function($query) use($course){

				if($course->labaides()->first())
					$query->where('id', '!=', $course->labaides->first()->id);

			})->get();

		
			$this->layout->content = View::make('admin.lotto.manual-edit-course', array (
				 	'currAide' => $course->labaides,
				 	'labaides' => $labaides,
				 	'course' => $course
				 	), Session::all()
			 );

			return;
		}catch(exception $e){

			return Redirect::to('/admin/schedule/home')->with(array( 
				'message' => 'unexpected error (admin) e',
				'message' => $e->getMessage()
				));

		}

		return Redirect::to('/admin/schedule/home')->with(array( 
			'message' => 'unexpected error ()'
			));
	}



	/*
	|--------------------------------------------------------------------------
	| Controller logic
	|--------------------------------------------------------------------------
	*/


	/*
		URL: /admin/schedule/import

		Grabs a JSON file from an external source.
		Parse the JSOn into an array format
			-format the time and dates.
		For each object try to create, update.
		Keep count along the way of create, update, or canceled courses.
		Return results.
	------------------------- */
	public function getImport(){
		
		echo "import";
		exit;

		$file = file_get_contents($_ENV['courseLink']);
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


		return Redirect::to('admin/schedule/home')->with( 
			array(
			'message' => "created: " . $newCourses .
			 ", updated: " . $updatedCourses . 
			 ", canceled: " . $canceledCourses,
			));
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
	public function getScheduler(){

		// echo "scheduler";
		// exit;
		//grab course list based off course level. lower -> higher priority
		foreach(Course::where('needs_coverage', '=', true)->get()->sortBy('course_number') as $course){

			//for every course - grab all users that can cover it.
			// 		Required skills
			// 		and must be able to aide within the time


			$eligibleLabaides = User::labAides()->hasSkill($course)
			->availableToLabaide($course)->get();

			// No labaides - skip and look at next course
			if($eligibleLabaides->count() == 0){
				continue;
			}
						
			//if only one labaide - assign as labaide
			if( $eligibleLabaides->count() == 1){
				$course->assignLabaide($eligibleLabaides->first());

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
			// otherwise randomly decide if all eligible are equal on skill count
			if($assignList->count() == 1){
				$course->assignLabaide($assignList->first());

				continue;

			} else if($eligibleLabaides->count() == $assignList->count()){

				$course->assignLabaide($assignList->get(rand(0, $eligibleLabaides->count()-1)));

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

			$course->assignLabaide($assignList->get(rand(0, $eligibleLabaides->count()-1)));

		}
		return Redirect::to('admin/schedule/home');	
	}


	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}

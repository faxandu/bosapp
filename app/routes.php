<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::post('login', 'UserController@login');
Route::get('logout', 'UserController@logout');
// Route::match(array('POST', 'GET'), 'asd', 'Lotto\controllers\CourseController@getImport');

View::name('layouts.layout', 'layout');
$layout = View::of('layout');

Route::get('/', function() use($layout) {
	return $layout->nest('content', 'home');
});


/*	Must be Authenticated  - auth grouping
-----------------------*/
Route::group(array('before' => 'auth'), function() use($layout){

	/*	Admin panel grouping
		Must be an Admin
	-----------------------*/
	Route::group(array('before' => 'admin'), function() use($layout){

		Route::group(array('prefix' => 'admin/'), function() use($layout){


			/*	admin user -> its grouping
			-----------------------*/
			Route::group(array('prefix' => 'user'), function() use($layout){


					
				/*	User home - listing users
				-----------------------*/
				Route::get('/', 'UserController@getAdminUserHomePage');

				/*	User create - form
				-----------------------*/
				Route::get('/create', 'UserController@getCreateUserPage');
				Route::post('/create', 'UserController@postCreateUser');

				Route::post('/delete', 'UserController@postDeleteUser');

			}); // end of admin user group



			/*	Schedule Management -> its grouping
			-----------------------*/
			Route::group(array('prefix' => 'schedule'), function() use($layout){

				/*	Schedule Management root
				-----------------------*/
				Route::get('/', function() use($layout) {
					return $layout->nest('content', 'admin.lotto.index');
				});

				/*	Schedule Management user list
				-----------------------*/
				Route::controller('user', 'Lotto\controllers\UserController');

				/*	Schedule Management user form
				-----------------------*/
				Route::get('user-assignment', function() use($layout) {
					return $layout->nest('content', 'admin.lotto.userSkillForm');
				});

				/*	Schedule Management course list
				-----------------------*/
				// Route::get('course-list', 'Lotto\controllers\CourseController@getAll');

				Route::controller('course', 'Lotto\controllers\CourseController');

				// Route::get('course-list', function() use($layout) {
				// 	return $layout->nest('content', 'admin.lotto.courseList');
				// });

			}); // end of schedule management group
			
			
		}); // end of admin auth

	}); // end of admin group
		

	/*	Schedule group User Side
	-----------------------*/
	Route::group(array('prefix' => 'schedule/'), function() use ($layout) {

		/*	Availability display
		-----------------------*/
		Route::controller('user', 'Lotto\controllers\UserController');

		/*	Availability display
		-----------------------*/
		Route::controller('availability', 'Lotto\controllers\AvailabilityController');
		// Route::get('/availability', function() use($layout) {
		// 	return $layout->nest('content', 'lotto.availability');
		// });
		//Route::controller('course', 'Lotto\controllers\CourseController');
		//Route::controller('skill', 'Lotto\controllers\SkillController');
		
		//Route::controller('user', 'Lotto\controllers\UserController');
	}); // end of schedule group

	Route::group(array('prefix' => 'group_study/'), function(){

		Route::controller('entry', 'GroupStudy\controllers\EntryController');
		Route::controller('report', 'GroupStudy\controllers\ReportController');


		Route::match(array('GET', 'POST'), '/checkPunchedIn', 'GroupStudy\controllers\EntryController@checkPunchedIn');
		Route::match(array('GET', 'POST'), '/StartEntry', 'GroupStudy\controllers\EntryController@StartEntry');

	});

	Route::group(array('prefix' => 'calendar/'), function() {

		Route::controller('entries', 'Calendar\controllers\EntriesController');
	});


    Route::group(array('prefix' => 'time/'), function() {
        Route::controller('entries', 'TimeTracking\controllers\TimeTrackingController');
    });



	Route::group(array('prefix' => 'inventory/'), function() {
		Route::controller('equipment', 'Inventory\controllers\EquipmentController');
		Route::controller('component', 'Inventory\controllers\ComponentController');
		Route::controller('contract', 'Inventory\controllers\ContractController');
	});

}); // end of auth group

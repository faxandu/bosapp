<?php

View::name('layouts.layout', 'layout');
$layout = View::of('layout');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function() use($layout) {
	return $layout->nest('content', 'home');
});

Route::post('login', 'UserController@login');
Route::get('logout', 'UserController@logout');


/*	Must be Authenticated  - auth grouping
-----------------------*/
Route::group(array('before' => 'auth'), function() use($layout){

	/*	Admin panel grouping
		Must be an Admin
	-----------------------*/
	Route::group(array('before' => 'admin'), function() use($layout){

		Route::group(array('prefix' => 'admin/'), function() use($layout){


			/*	admin user uses user functions
			-----------------------*/
			Route::controller('user', 'UserController');



			/*	Schedule Management grouping
			-----------------------*/
			Route::group(array('prefix' => 'schedule'), function() use($layout){

				/*	Schedule Management root
				-----------------------*/
				Route::get('/', function() use($layout) {
					return $layout->nest('content', 'admin.lotto.home');
				});

				/*	Schedule Management user list
				-----------------------*/
				Route::controller('user', 'Lotto\controllers\UserController');

				Route::controller('course', 'Lotto\controllers\CourseController');

				Route::controller('skill', 'Lotto\controllers\SkillController');

			}); // end of schedule management group
			
			
		}); // end of admin auth

	}); // end of admin group
		

	/*	Schedule group User Side
	-----------------------*/
	Route::group(array('prefix' => 'schedule/'), function() use ($layout) {

		Route::controller('user', 'Lotto\controllers\UserController');

		/*	Availability display
		-----------------------*/
		Route::controller('availability', 'Lotto\controllers\AvailabilityController');

	}); // end of schedule group user side






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

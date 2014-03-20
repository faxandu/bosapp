<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => 'global/'), function(){
	Route::match(array('POST', 'GET'), 'createUser', 'UserController@create');
	Route::match(array('POST', 'GET'), 'deleteUser', 'UserController@delete');
	Route::match(array('POST', 'GET'), 'getUser', 'UserController@get');

	
});

Route::group(array('prefix' => 'lotto/'), function(){

	Route::controller('course', 'Lotto\controllers\CourseController');
	// Route::controller('skill', 'Lotto\controllers\SkillController');
	// Route::controller('course', 'Lotto\controllers\CourseController');
	// Route::controller('course', 'Lotto\controllers\CourseController'); 
	// Route::match(array('POST', 'GET'), 'createCourse', 'Lotto\controllers\CourseController@create'); 
	// Route::match(array('POST', 'GET'), 'createCourse', 'Lotto\controllers\CourseController@create'); 
	// Route::match(array('POST', 'GET'), 'deleteCourse', 'Lotto\controllers\CourseController@delete'); // (id)
	// Route::match(array('POST', 'GET'), 'getCourse', 'Lotto\controllers\CourseController@get'); // (id) or () Also grabs the labaides
	// Route::match(array('POST', 'GET'), 'removeLabAide', 'Lotto\controllers\CourseController@removeLabAide'); // (user, course)
	// Route::match(array('POST', 'GET'), 'setLabAide', 'Lotto\controllers\CourseController@setLabAide'); // (user, course)
	// Route::match(array('POST', 'GET'), 'updateCourse', 'Lotto\controllers\CourseController@update');

	// Route::match(array('POST', 'GET'), 'getSkill', 'Lotto\controllers\SkillController@get');
	// Route::match(array('POST', 'GET'), 'getUserSkill', 'Lotto\controllers\SkillController@getUserSkill');
	// Route::match(array('POST', 'GET'), 'removeUserSkill', 'Lotto\controllers\SkillController@deleteUserSkill');
	// Route::match(array('POST', 'GET'), 'setUserSkill', 'Lotto\controllers\SkillController@setUserSkill');


	// Route::match(array('POST', 'GET'), 'createStaffType', 'StaffTypeController@create');
	// Route::match(array('POST', 'GET'), 'deleteStaffType', 'StaffTypeController@delete');
	// Route::match(array('POST', 'GET'), 'getStaffType', 'StaffTypeController@get');
	// Route::match(array('POST', 'GET'), 'getUserStaffType', 'StaffTypeController@getUserStaffType');
	// Route::match(array('POST', 'GET'), 'removeUserStaffType', 'StaffTypeController@removeUserStaffType');
	// Route::match(array('POST', 'GET'), 'setUserStaffType', 'StaffTypeController@setUserStaffType');

	// Route::match(array('POST', 'GET'), 'deleteUser', 'UserController@delete');
	// Route::match(array('POST', 'GET'), 'getUser', 'UserController@get');

	// Route::match(array('POST', 'GET'), 'createEntry', 'EntryController@create');
	// Route::match(array('POST', 'GET'), 'getEntry', 'EntryController@get');
	// Route::match(array('POST', 'GET'), 'deleteEntry', 'EntryController@delete');
	// Route::match(array('POST', 'GET'), 'removeEntryFromUser', 'EntryController@removeEntryFromUser');
	// Route::match(array('POST', 'GET'), 'setEntryToUser', 'EntryController@setEntryToUser');

	// Route::post('setUser', 'UserController@set');

});

Route::group(array('prefix' => 'group_study/'), function(){

	Route::match(array('POST', 'GET'), '/group_study/add_student', 'EntryController@add_student');

	Route::match(array('POST', 'GET'), '/group_study/student_exists', 'EntryController@student_exists');

	Route::match(array('POST', 'GET'), '/group_study/get_report', 'ReportController@get_report');

	Route::match(array('POST', 'GET'), '/group_study/delete_student', 'EntryController@delete_student');

	Route::match(array('POST', 'GET'), '/group_study/modify_student', 'EntryController@modify_student');
	
});


<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// ---------------- Testing pages ------------- //

Route::get('course', function()
{
	return View::make('courseForm');
});

Route::get('entry', function()
{
	return View::make('entryForm');
});

Route::get('user', function()
{
	return View::make('userForm');
});

Route::get('staff', function()
{
	return View::make('staffForm');
});


Route::get('userSkill', function()
{
	return View::make('userSkill');
});


Route::get('userStaff', function()
{
	return View::make('userStaff');
});

// ----------------------------------------------------------



Route::match(array('POST', 'GET'), '/lotto/createCourse', 'CourseController@create'); 
Route::match(array('POST', 'GET'), '/lotto/deleteCourse', 'CourseController@delete'); // (id)
Route::match(array('POST', 'GET'), '/lotto/getCourse', 'CourseController@get'); // (id) or () Also grabs the labaides
Route::match(array('POST', 'GET'), '/lotto/removeLabAide', 'CourseController@removeLabAide'); // (user, course)
Route::match(array('POST', 'GET'), '/lotto/setLabAide', 'CourseController@setLabAide'); // (user, course)
Route::match(array('POST', 'GET'), '/lotto/updateCourse', 'CourseController@update');

Route::match(array('POST', 'GET'), '/lotto/getSkill', 'SkillController@get');
Route::match(array('POST', 'GET'), '/lotto/getUserSkill', 'SkillController@getUserSkill');
Route::match(array('POST', 'GET'), '/lotto/removeUserSkill', 'SkillController@deleteUserSkill');
Route::match(array('POST', 'GET'), '/lotto/setUserSkill', 'SkillController@setUserSkill');


Route::match(array('POST', 'GET'), '/lotto/createStaffType', 'StaffTypeController@create');
Route::match(array('POST', 'GET'), '/lotto/deleteStaffType', 'StaffTypeController@delete');
Route::match(array('POST', 'GET'), '/lotto/getStaffType', 'StaffTypeController@get');
Route::match(array('POST', 'GET'), '/lotto/getUserStaffType', 'StaffTypeController@getUserStaffType');
Route::match(array('POST', 'GET'), '/lotto/removeUserStaffType', 'StaffTypeController@removeUserStaffType');
Route::match(array('POST', 'GET'), '/lotto/setUserStaffType', 'StaffTypeController@setUserStaffType');

Route::match(array('POST', 'GET'), '/lotto/deleteUser', 'UserController@delete');
Route::match(array('POST', 'GET'), '/lotto/getUser', 'UserController@get');

Route::match(array('POST', 'GET'), '/lotto/createEntry', 'EntryController@create');
Route::match(array('POST', 'GET'), '/lotto/getEntry', 'EntryController@get');
Route::match(array('POST', 'GET'), '/lotto/deleteEntry', 'EntryController@delete');
Route::match(array('POST', 'GET'), '/lotto/removeEntryFromUser', 'EntryController@removeEntryFromUser');
Route::match(array('POST', 'GET'), '/lotto/setEntryToUser', 'EntryController@setEntryToUser');

Route::post('setUser', 'UserController@set');

//-------------------------------------------------------------------------------------------------------------------------
//Group Study Tracker

Route::get('add_student', 'EntryController@add_student');

Route::get('student_exists', 'EntryController@student_exists');

Route::get('get_report', 'ReportController@get_report');
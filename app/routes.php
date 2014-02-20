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



Route::match(array('POST', 'GET'), 'createCourse', 'CourseController@create');
Route::match(array('POST', 'GET'), 'deleteCourse', 'CourseController@delete');
Route::match(array('POST', 'GET'), 'getCourse', 'CourseController@get'); // Also grabs the labaides
Route::match(array('POST', 'GET'), 'setLabAide', 'CourseController@setLabAide');


Route::match(array('POST', 'GET'), 'getSkill', 'SkillController@get');

Route::match(array('POST', 'GET'), 'createStaffType', 'StaffTypeController@create');
Route::match(array('POST', 'GET'), 'deleteStaffType', 'StaffTypeController@delete');
Route::match(array('POST', 'GET'), 'getUserStaffType', 'StaffTypeController@getUserStaffType');
Route::match(array('POST', 'GET'), 'setUserStaff', 'StaffTypeController@setUserStaffType');

Route::match(array('POST', 'GET'), 'deleteUser', 'UserController@delete');
Route::match(array('POST', 'GET'), 'deleteUserSkill', 'UserController@deleteUserSkill');
Route::match(array('POST', 'GET'), 'getUser', 'UserController@get');
Route::match(array('POST', 'GET'), 'getUserSkill', 'UserController@getUserSkill');
Route::match(array('POST', 'GET'), 'setUserSkill', 'UserController@setUserSkill');


Route::post('setUser', 'UserController@set');


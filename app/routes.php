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



Route::match(array('POST', 'GET'), '/lotto/createCourse', 'CourseController@create');
Route::match(array('POST', 'GET'), '/lotto/deleteCourse', 'CourseController@delete');
Route::match(array('POST', 'GET'), '/lotto/getCourse', 'CourseController@get'); // Also grabs the labaides
Route::match(array('POST', 'GET'), '/lotto/setLabAide', 'CourseController@setLabAide');
Route::match(array('POST', 'GET'), '/lotto/updateCourse', 'CourseController@update');

Route::match(array('POST', 'GET'), '/lotto/getSkill', 'SkillController@get');

Route::match(array('POST', 'GET'), '/lotto/createStaffType', 'StaffTypeController@create');
Route::match(array('POST', 'GET'), '/lotto/deleteStaffType', 'StaffTypeController@delete');
Route::match(array('POST', 'GET'), '/lotto/getStaffType', 'StaffTypeController@get');
Route::match(array('POST', 'GET'), '/lotto/getUserStaffType', 'StaffTypeController@getUserStaffType');
Route::match(array('POST', 'GET'), '/lotto/setUserStaffType', 'StaffTypeController@setUserStaffType');

Route::match(array('POST', 'GET'), '/lotto/deleteUser', 'UserController@delete');
Route::match(array('POST', 'GET'), '/lotto/deleteUserSkill', 'UserController@deleteUserSkill');
Route::match(array('POST', 'GET'), '/lotto/getUser', 'UserController@get');
Route::match(array('POST', 'GET'), '/lotto/getUserSkill', 'UserController@getUserSkill');
Route::match(array('POST', 'GET'), '/lotto/setUserSkill', 'UserController@setUserSkill');


Route::post('setUser', 'UserController@set');


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
Route::match(array('POST', 'GET'), 'setCourse', 'CourseController@set');
Route::match(array('POST', 'GET'),'getCourse', 'CourseController@get');
Route::get('deleteCourse', 'CourseController@delete');


Route::post('setUser', 'UserController@set');
Route::get('getUser', 'UserController@get');
Route::get('deleteUser', 'UserController@delete');


Route::get('getUserSkill', 'UserController@getUserSkill');
Route::post('setUserSkill', 'UserController@setUserSkill');
Route::get('deleteUserSkill', 'UserController@deleteUserSkill');


Route::get('getSkill', 'SkillController@get');

Route::post('setStaff', 'StaffController@set');
Route::post('setUserStaff', 'StaffController@setUserStaff');
Route::get('getUserStaff', 'StaffController@getUserStaff');
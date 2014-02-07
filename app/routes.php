<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function()
{
	$course = new Course;
	$course->name = "bob";
	return "hello";
});
Route::get('course', function()
{
	return View::make('courseForm');
});

Route::get('user', function()
{
	return View::make('userForm');
});


Route::get('userSkill', function()
{
	return View::make('userSkill');
});

// Route::post( 'setCourse', array('as' => 'setCourse', 'uses' => 'CourseController@setCourse'));
// Route::get( 'getCourse', array('as' => 'getCourse', 'uses' => 'CourseController@getCourse'));
// Route::get( 'deleteCourse', array('as' => 'deleteCourse', 'uses' => 'CourseController@getCourse'));
//Route::get('url', 'Controller@function');

Route::post('setCourse', 'CourseController@setCourse');
Route::get('getCourse', 'CourseController@getCourse');
Route::get('deleteCourse', 'CourseController@deleteCourse');

Route::post('setUser', 'UserController@setUser');
Route::get('getUser', 'UserController@getUser');
Route::get('deleteUser', 'UserController@deleteUser');
Route::get('getUserSkill', 'UserController@getUserSkill');
Route::post('setUserSkill', 'UserController@setUserSkill');
Route::get('deleteUserSkill', 'UserController@deleteUserSkill');


Route::get('getSkill', 'SkillController@getSkill');

//Route::resource('course', 'CourseController', array('names' => array('create' => 'course.build')));
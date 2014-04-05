<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/


Route::match(array('POST', 'GET'), 'login', 'UserController@postLogin');
Route::match(array('POST', 'GET'), 'logout', 'UserController@postLogout');
Route::match(array('POST', 'GET'), 'asd', 'Lotto\controllers\CourseController@getImport');

View::name('layouts.layout', 'layout');
$layout = View::of('layout');

Route::get('/', function() use($layout) {
	return $layout->nest('content', 'home');
});



Route::group(array('before' => 'auth'), function()
{

	Route::group(array('prefix' => 'global/'), function(){
		Route::controller('user', 'UserController');
	});


	Route::group(array('prefix' => 'lotto/'), function(){

		Route::controller('course', 'Lotto\controllers\CourseController');
		Route::controller('skill', 'Lotto\controllers\SkillController');

	});

	Route::group(array('prefix' => 'group_study/'), function(){

		Route::controller('entry', 'GroupStudy\controllers\EntryController');
		Route::controller('report', 'GroupStudy\controllers\ReportController');

	});

	Route::group(array('prefix' => 'calendar/'), function() {

		Route::controller('entries', 'Calendar\controllers\EntriesController');
	});

});



Route::match(array('GET', 'POST'), '/checkPunchedIn', 'GroupStudy\controllers\EntryController@checkPunchedIn');
Route::match(array('GET', 'POST'), '/StartEntry', 'GroupStudy\controllers\EntryController@StartEntry');

Route::match(array('GET', 'POST'), '/add_equipment', 'Inventory\controllers\EquipmentController@addEquipment');
Route::match(array('GET', 'POST'), '/add_component', 'Inventory\controllers\ComponentController@addComponent');
Route::match(array('GET', 'POST'), '/add_contract', 'Inventory\controllers\ContractController@addContract');

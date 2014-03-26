<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
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

});


Route::resource('user', 'UserController',
                array('only' => array('getLogin')));

Route::group(array('prefix' => 'calendar/'), function() {

	Route::controller('entries', 'Calendar\controllers\EntriesController');
});


<?php

use Lotto\models\Availability, Lotto\models\Course, Lotto\models\Skill;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
	}

}


class ManyTableSeeder extends Seeder{

	public function run(){

		//bob can cover two courses
		// dave can only cover one
		// robert can only cover one

		//bob can cover one that dave can, and one that dave cannot.
		// dave and robert can only cover one.

		
		$bob = User::create(array('email' => 'b@b.b','username' => 'bob', 'admin' => true, 'type' => 'labAide', 'password' => Hash::make('1')));
		$dave = User::create(array('email' => 'd@b.b','username' => 'dave', 'type' => 'labAide', 'password' => Hash::make('1')));
		$robert = User::create(array('email' => 'r@b.b','username' => 'robert', 'type' => 'labAide', 'password' => Hash::make('1')));
		$fog = User::create(array('email' => 'f@b.b', 'username' => 'fog', 'type' => 'labAide', 'password' => Hash::make('1')));



		$course1 = Course::create(array('course_title' => 'CPS 171', 'course_number' => '1', 'crn' => '1',
		 'start_time' => '08:30:00', 'end_time' => '09:30:00',
		 'start_date' => '2004/02/01', 'end_date' => '2004/02/01'));

		$course2 = Course::create(array('course_title' => 'CPS 171', 'course_number' => '2', 'crn' => '2',
		 'start_time' => '08:30:00', 'end_time' => '09:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));

		$course3 = Course::create(array('course_title' => 'CPS 161', 'course_number' => '3', 'crn' => '3',
		 'start_time' => '10:30:00', 'end_time' => '11:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));


		$course4 = Course::create(array('course_title' => 'CPS 181', 'course_number' => '4', 'crn' => '4',
		 'start_time' => '10:30:00', 'end_time' => '11:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));

		// User::find(1)->skills()->attach(Skill::find(1));

		$skill1 = Skill::where('name', '=', $course1->course_title)->firstOrFail();
		$skill2 = Skill::where('name', '=', $course2->course_title)->firstOrFail();
		$skill3 = Skill::where('name', '=', $course3->course_title)->firstOrFail();
		$skill4 = Skill::where('name', '=', $course4->course_title)->firstOrFail();

		// bobs
		$bobsA1 = Availability::create(array('start_time' => '08:30:00','end_time' => '09:30:00',
		 'day_of_week' => 'M'));

		$bobsA2 = Availability::create(array('start_time' => '08:30:00','end_time' => '09:30:00',
		 'day_of_week' => 'Tu'));

		$bob->skills()->attach($skill1->id);
		$bob->skills()->attach($skill3->id);
		$bob->skills()->attach($skill4->id);
		$bob->availability()->attach($bobsA1->id);
		$bob->availability()->attach($bobsA2->id);
		$bob->courses()->attach($course1->id);
		//daves
		$davesA1 = Availability::create(array('start_time' => '08:30:00','end_time' => '09:30:00',
		 'day_of_week' => 'M'));


		$dave->skills()->attach($skill1->id);
		$dave->availability()->attach($davesA1->id);
		//robs
		$robertsA1 = Availability::create(array('start_time' => '10:30:00','end_time' => '11:30:00',
		 'day_of_week' => 'Tu'));

		$robert->skills()->attach($skill2->id);
		$robert->availability()->attach($robertsA1->id);

		//fogs
		$fog->skills()->attach($skill4->id);
		$fog->skills()->attach($skill1->id);
		$fog->availability()->attach($davesA1->id);
	}


}




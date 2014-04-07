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

class UserTableSeeder extends Seeder{

	public function run(){
		DB::table('user')->delete();
		User::create(array('username' => 'bob', 'type' => 'labAide', 'password' => Hash::make('1')));
		User::create(array('username' => 'fred', 'type' => 'labAide', 'password' => Hash::make('1')));
		User::create(array('username' => 'dave', 'type' => 'labAide', 'password' => Hash::make('1')));
	}


}

class ManyTableSeeder extends Seeder{

	public function run(){

		//bob can cover two courses
		// dave can only cover one
		// robert can only cover one

		//bob can cover one that dave can, and one that dave cannot.
		// dave and robert can only cover one.

		
		$bob = User::create(array('username' => 'bob', 'type' => 'labAide', 'password' => Hash::make('1')));
		$dave = User::create(array('username' => 'dave', 'type' => 'labAide', 'password' => Hash::make('1')));
		$robert = User::create(array('username' => 'robert', 'type' => 'labAide', 'password' => Hash::make('1')));

		$course1 = Course::create(array('course_title' => 'CPS 171', 'crn' => '1',
		 'start_time' => '08:30:00', 'end_time' => '09:30:00',
		 'start_date' => '2004/02/01', 'end_date' => '2004/02/01'));

		$course2 = Course::create(array('course_title' => 'CPS 171','crn' => '2',
		 'start_time' => '08:30:00', 'end_time' => '09:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));

		$course3 = Course::create(array('course_title' => 'CPS 161', 'crn' => '3',
		 'start_time' => '10:30:00', 'end_time' => '11:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));

		// User::find(1)->skills()->attach(Skill::find(1));

		$skills = Skill::all();
		$skill2 = $skills->first();
		$skill1 = Skill::where('name', '=', $course1->course_title)->firstOrFail();

		// bobs
		$bobsA1 = Availability::create(array('start_time' => '08:30:00','end_time' => '09:30:00',
		 'start_date' => '2004/02/01', 'end_date' => '2004/02/01'));

		$bobsA2 = Availability::create(array('start_time' => '08:30:00','end_time' => '09:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));

		$bob->skills()->attach($skill1->id);
		$bob->availability()->attach($bobsA1->id);
		$bob->availability()->attach($bobsA2->id);

		//daves
		$davesA1 = Availability::create(array('start_time' => '08:30:00','end_time' => '09:30:00',
		 'start_date' => '2004/02/01', 'end_date' => '2004/02/01'));


		$dave->skills()->attach($skill1->id);
		$dave->availability()->attach($davesA1->id);
		//robs
		$robertsA1 = Availability::create(array('start_time' => '10:30:00','end_time' => '11:30:00',
		 'start_date' => '2004/02/02', 'end_date' => '2004/02/02'));

		$robert->skills()->attach($skill2->id);
		$robert->availability()->attach($robertsA1->id);
	}


}


class AvailabilityTableSeeder extends Seeder{

	public function run(){
		DB::table('schedule_availability')->delete();
		Availability::create(array('start_time' => '08:50:00', 
			'end_time' => '09:50:00', 'start_date' => '2004/02/01',
			 'end_date' => '2004/02/01'));
	}


}



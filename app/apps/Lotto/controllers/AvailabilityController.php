<?php 

namespace Lotto\controllers;

use BaseController, Lotto\models\Availability, User;
use Auth, Date;
use Input, Response, Exception, Session, Redirect;
use View;

class AvailabilityController extends BaseController {


	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/

	public function getCreate(){

		$this->layout->content = View::make('lotto.availability.create');
	}


	public function getMyAvailability(){

		/*
		$this->layout->content = View::make('lotto.availability.home')->with(array(

			'user' => Auth::user(), 
			'userAvailability' => Auth::user()->availability,
			Session::all()

			));
		*/
		$this->layout->content = View::make('user.availability', array('availability' => Auth::user()->availability));

	}


	public function getAvail() {

		$avail = Auth::user()->availability;
		$today = date('m/d/Y');
		$sun = date('m/d/Y', strtotime('last sunday', strtotime($today)));

		foreach ($avail as $item) {
			$item->start_date = date('m/d/Y', strtotime($sun . ' + ' . $item->weekday . ' days'));
		}

		return Response::json(Auth::user()->availability);
	}

	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/

	/*	
		Feature? If a time already exists just add a link to user?


	----------------------------------- */
	public function postCreate(){
	
		$input = Input::all();

		$checkedInput = Availability::validate($input);

		if($checkedInput->fails()){

			/*
			return Redirect::to('/schedule/availability/create')->with(array(
				'status' => 400,
				'error' => $checkedInput->messages()->all()
			));
			*/
			return Redirect::to('/schedule/availability/my-availability')->with('message', $checkedInput->messages()->all());
		
		}

		try{

			$user = Auth::user();

			$availability = Availability::create($input);

			$user->availability()->attach($availability);


		} catch(Exception $e){

			/*
			return Redirect::to('/schedule/availability/create')->with(array(
				'status' => 400,
				'error' => $checkedInput->messages()->all()
			));
			*/
			return Redirect::to('/schedule/availability/my-availability')->with('message', $checkedInput->messages()->all());
			
		}

		return Redirect::to('/schedule/availability/my-availability');
		
	}	


	/*	
		Feature? only if no users attached then delete?


	----------------------------------- */

	public function postUpdate() {
		$item = Availability::find(Input::get('id'));
		$item->fill(Input::all());
		$item->save();

		return Response::json(array(
			'status' => 200,
			'message' => 'Entry Updated'
			));
	}

	public function postDelete(){
		
		$id = Input::get('id');

		try{ 
			

			$availability = Availability::findOrFail($id);
			
			$availability->delete();

		}catch(exception $e){
			
			return Redirect::to('/schedule/availability/my-availability')->with(array(
				'status' => 400,
				'error' => $checkedInput->messages()->all()
			));
		}
		
			return Redirect::to('/schedule/availability/my-availability')->with(array(
				'status' => 200
			));;
	}

}


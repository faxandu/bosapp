<?php
namespace Calendar\controllers;
use BaseController, Input, User, Response, Entry, View, Redirect, Eloquent, Session, Exception;
use Illuminate\Support\Facades\Auth;
use Calendar\models\EventEntry;


class EntriesController extends BaseController {

	public function getIndex() {
		$this->layout->content = View::make('calendar.home');
	}

	public function getEvents() {
		//$events = EventEntry::all();
		$events = EventEntry::where('created_for', '=', 'all')->orwhere('created_for', '=', Auth::user()->username)->orwhere('created_by', '=', Auth::user()->username)->get();
		$events->toArray();
		//foreach($events as $value ){
			//$value->start_date = date('Y-m-d H:i', strtotime($value->start_date));
		//}
		return Response::json($events->toArray(), 200);
	}

	public function postCreate() {
		$entry = new EventEntry();
		$entry->title = Input::get('title');
		$entry->start_date = Input::get('start_date');
		$entry->end_date = Input::get('end_date');
		$entry->description = Input::get('description');
		$entry->created_by = Auth::user()->username;
		$entry->last_updated_by = Auth::user()->username;
		if(Auth::user()->admin == 1){
			if(empty(Input::get('for'))){
				$entry->created_for = Auth::user()->username;
			} else{
				$entry->created_for = strtolower(Input::get('for'));
			}
		
		} else{
			$entry->created_for = Auth::user()->username;
		}
		
		if(empty($entry->start_date) || empty($entry->end_date)){
			 return Redirect::back()->with('message', 'Invalid dates')->with('alert', 'danger');
		}

		try {
			$entry->save();
			 return Redirect::back()->with('message', 'Event Created')->with('alert', 'success');
		} catch(exception $e) {
			return Redirect::back()->with('message', 'Event Creation Failed')->with('alert', 'danger');
		}
	}

	public function postUpdate() {
		$post = Input::all();
		$entry = EventEntry::find($post['id']);
		if($entry->created_by==Auth::user()->username || Auth::user()->admin == 1){
			if(!empty($post['title']))
				$entry->title = $post['title'];
			if(Auth::user()->admin == 1){
				if(empty($post['created_for'])){
					$entry->created_for = Auth::user()->username;
				} else{
					$entry->created_for = strtolower($post['created_for']);
				}
		
			} else{
				if(!empty($post['created_for']))
					$entry->created_for = Auth::user()->username;
			}
			$entry->start_date = $post['start_date'];
			$entry->end_date = $post['end_date'];
			$entry->last_updated_by = Auth::user()->username;
			if(isset($post['description']))
				$entry->description = $post['description'];
		} else{
			return Redirect::back()->with('message', 'No Permissions')->with('alert', 'danger');
		}
		

			
		try {
			$entry->save();
			return Redirect::back()->with('message', 'Event Saved Successfully')->with('alert', 'success');
		} catch(exception $e) {
			//return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
			return Redirect::back()->with('message', 'Event Saving Failed')->with('alert', 'danger');
		}
	}

	public function postDestroy() {
		try {
			if(Input::get('created_by') == Auth::user()->username || Auth::user()->admin == 1){
				EventEntry::destroy(Input::get('id'));
				return Redirect::back()->with('message', 'Event Deleted')->with('alert', 'success');
			} else{
				return Redirect::back()->with('message', 'No Permissions')->with('alert', 'danger');
			}
			
		} catch(exception $e) {
			//return Response::json(array('status' => 400, 'message' => 'Entry Deletion Failure', 'error' => $e), 400);
			return Redirect::back()->with('message', ' Event Deletion Failure')->with('alert', 'danger');
		}
	}

}
<?php
namespace Calendar\controllers;
use BaseController, Input, Response, Entry, View, Redirect;

class EntriesController extends BaseController {

	

	public function __construct() {
	   $this->beforeFilter('csrf', ['on' => 'post', 'delete']);
	}

	public function getIndex() {
		$this->layout->content = View::make('calendar.home');
	}

	public function getEvents() {
		$events = Entry::all();
		return Response::json($events->toArray(), 200);
	}

	public function postCreate() {

		$entry = new Entry;
		$entry->title = Input::get('title');
		$entry->start_date = Input::get('start_date');
		$entry->end_date = Input::get('end_date');
		$entry->description = Input::get('description');

		try {
			$entry->save();
			return Redirect::to('calendar/entries');
		} catch(exception $e) {
			return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
		}
	}

	public function postUpdate() {
		$post = Input::all();
		$entry = Entry::find($post['id']);
		$entry->start_date = $post['start_date'];
		$entry->end_date = $post['end_date'];

		try {
			$entry->save();
			return Response::json(array('status' => 201, 'message' => 'Entry Saved Successfully'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
		}
	}

	public function postDestroy() {
		try {
			Entry::destroy(Input::get('id'));
			return Response::json(array('status' => 200, 'message' => 'Entry Deleted'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 400, 'message' => 'Entry Deletion Failure', 'error' => $e), 400);
		}
	}

}
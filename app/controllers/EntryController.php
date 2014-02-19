<?php

class EntryController extends Controller {

	public function __construct() {
	   //$this->beforeFilter('csrf', ['on' => 'post', 'delete']);
	}

	public function get() {
		if (Input::has('month')) {
			$month = Input::get('month');
			$events = Entry::whereraw('MONTH(date) = '.$month)->get();
		} else {
			$events = Entry::all();
		}
		return Response::json($events->toArray(), 200);

	}

	public function add() {

		$entry = new Entry;
		$entry->title = Input::get('title');
		$entry->date = Input::get('date');
		$entry->time = Input::get('time');
		$entry->description = Input::get('description');

		try {
			$entry->save();
			return Response::json(array('status' => 201, 'message' => 'Entry Saved Successfully'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
		}
	}

	public function update() {
		$post = Input::all();
		$entry = Entry::find($post['id']);
		$entry->date = $post['date'];

		try {
			$entry->save();
			return Response::json(array('status' => 201, 'message' => 'Entry Saved Successfully'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
		}
	}

	public function destroy() {
		try {
			Entry::delete(Input::get('id'));
			return Response::json(array('status' => 200, 'message' => 'Entry Deleted'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 400, 'message' => 'Entry Deletion Failure', 'error' => $e), 400);
		}
	}

}
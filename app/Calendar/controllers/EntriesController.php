<?php
namespace Calendar\controllers;
use BaseController, Input, Response, Calendar\models\Entries;

class EntriesController extends BaseController {

	public function __construct() {
	   $this->beforeFilter('csrf', ['on' => 'post', 'delete']);
	}

	public function getIndex() {
		$events = Entries::all();
		return Response::json($events->toArray(), 200);
	}

	public function postCreate() {

		$entry = new Entries;
		$entry->title = Input::get('title');
		$entry->start = Input::get('start');
		$entry->end = Input::get('end');
		$entry->description = Input::get('description');

		try {
			$entry->save();
			return Response::json(array('status' => 201, 'message' => 'Entry Saved Successfully'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
		}
	}

	public function postUpdate() {
		$post = Input::all();
		$entry = Entries::find($post['id']);
		$entry->start = $post['start'];
		$entry->end = $post['end'];

		try {
			$entry->save();
			return Response::json(array('status' => 201, 'message' => 'Entry Saved Successfully'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 401, 'message' => 'Entry Save Failed', 'error' => $e), 400);
		}
	}

	public function postDestroy() {
		try {
			Entries::delete(Input::get('id'));
			return Response::json(array('status' => 200, 'message' => 'Entry Deleted'), 201);
		} catch(exception $e) {
			return Response::json(array('status' => 400, 'message' => 'Entry Deletion Failure', 'error' => $e), 400);
		}
	}

}
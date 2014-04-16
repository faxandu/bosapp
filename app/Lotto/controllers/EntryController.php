 <?php 
 namespace Lotto\controllers;
 use BaseController, Lotto\models\Entry;

class EntryController extends Controller {


	public function create(){
		$input = Input::all();
		
		//$validatedInput = Course::validate(Input::all());

		//$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		//if(!$messages->all()){
			try{

				$entry = Entry::create($input);

				return Response::json(array('status' => 201, 'message' => 'Entry created'), 201);

			}catch(Exception $e){
				return Response::json(array('status' => 400, 
					'message' => 'Failed to create entry', 'error' => $e), 400);
			}
		//}
		// return Response::json(array('status' => 400,
		 // 'message' => 'Failed to create entry', 'error' => $messages->all() ), 400);
	}	

	public function delete(){
		
		try{ 
			$id = Input::get('id');

			$entry = Entry::findOrFail($id);
			
			$entry->forceDelete();

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete entry.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'Course Deleted'), 200);
	}

	public function get(){
		
		try{	

			if(!Input::has('id'))
				return Response::json(Entry::all());

			$id = Input::get('id');

			$entry = Entry::findOrFail($id);
			
			return Response::json($entry->toarray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get entry.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function removeEntryFromUser(){
		
		try{
			$userId = Input::get('user');
			$entryId = Input::get('entry');

			User::findorFail($userId)->entries()->detatch($entryId);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to remove entry.', 'error' => $e->getMessage()), 400);
		}

		return Response::json(array('status' => 200, 'message' => 'entry removed'), 200);
	}

	public function setEntryToUser(){
		$entryId = Input::get('entry');
		$userId = Input::get('user');
		
		try{

			$user = User::findorFail($userId);
			$entry = Entry::findorFail($entryId);

			$user->entries()->attach($entry);

		}catch(exception $e){
			return Response::json(array('status' => 400, 
				'message' => 'Failed to assign entry', 'error' => $e->getMessage()), 400);
		}
		
		return Response::json(array('status' => 201, 'message' => 'entry assigned'), 201);
	 }	

}


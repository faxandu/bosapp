<?php

class UserController extends BaseController {

	public function postCreate(){
		$input = Input::all();
		
		//$validatedInput = Course::validate(Input::all());

		//$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		//if(!$messages->all()){
			try{

				$user = User::create($input);

				return Response::json(array('status' => 201, 'message' => 'User created'), 201);

			}catch(Exception $e){
				return Response::json(array('status' => 400, 
					'message' => 'Failed to create user', 'error' => $e), 400);
			}
		//}
		return Response::json(array('status' => 400,
		 'message' => 'Failed to create User', 'error' => $messages->all() ), 400);
	}


	public function postDelete(){
		
		try{
			$id = Input::get('id');
			$user = User::findOrFail($id);
			$user->skills()->detach();
			$user->labAide()->detach();
			$user->staffType()->detach();
			$user->forceDelete();
		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete user.', 'error' => $e->getMessage()), 400);
		}
		return Response::json(array('status' => 200, 'message' => 'User Deleted'), 200);
	}



	public function get(){
		
		try{	

			if(!Input::has('id')){
				$users = array();
				foreach ( User::all() as $user){
					//array_push($users, array('user' => $user->toarray(), 'staffType' => $user->staffTypes()->toArray()  ) );
					$user->staffTypes->toarray();
					$user->entries->toarray();
					array_push($users, $user->toarray());
				}
				return Response::json($users);
			}

			$id = Input::get('id');
			$user =  User::findOrFail($id);
			$user->staffTypes->toarray();
			$user->entries->toarray();
			return Response::json($user);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get user.', 'error' => $e->getMessage()), 400);
		}		
	}


	public function getLogin() {
		if (Auth::attempt(array('username'=>Input::get('username'), 'password'=>Input::get('password')))) {
		    return Redirect::to('users/dashboard')->with('message', 'You are now logged in!');
		} else {
		    return Redirect::to('/')
		        ->with('message', 'Your username/password combination was incorrect')->with('alert', 'warning')
		        ->withInput();
		}
	}

	// public function getEntry(){
		
	// 	try{	

	// 		$id = Input::get('id');
	// 		$user =  User::findOrFail($id);
	// 		$userArr['entries'] = $user->entries->toarray();
	// 		return Response::json($userArr);

	// 	}catch(exception $e){
	// 		return Response::json(array('status' => 400, 	
	// 		'message' => 'Failed to get user.', 'error' => $e->getMessage()), 400);
	// 	}		
	// }
}
<?php

class UserController extends BaseController {

	public function getCreate(){
		$this->layout->content = View::make('user.create')->nest('form', 'user.form');
	}

	public function postCreate(){
		$input = Input::all();
		
		//$validatedInput = Course::validate(Input::all());

		//$messages = $validatedInput->messages();

		// if any error messages, don't create and return errors.
		//if(!$messages->all()){
			try{

				$input['password'] = Hash::make($input['password']);
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
		$id = Input::get('id');

		try{

			$user = User::findOrFail($id);
			
		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to delete user.', 'error' => $e->getMessage()), 400);
		}

		
		$user->delete();


		return Response::json(array('status' => 200, 'message' => 'User Deleted'), 200);
	}

	public function getGet(){
		return Response::json(User::all());
	}

	public function postGet(){
		
		$id = Input::get('id');

		try{	

			$user =  User::findOrFail($id);

			return Response::json($user);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get user.', 'error' => $e->getMessage()), 400);
		}		
	}


	public function postGetUserAvailability(){
		
		$id = Input::get('id');

		try{	

			$user =  User::findOrFail($id);
			$user->availability->toarray();

			return Response::json($user->toArray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get user.', 'error' => $e->getMessage()), 400);
		}		
	}

	public function postGetUserSkills(){
		
		$id = Input::get('id');

		try{	

			$user =  User::findOrFail($id);
			$user->skills->toarray();

			return Response::json($user->toArray());

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get user.', 'error' => $e->getMessage()), 400);
		}		
	}
	
	public function postLogin() {
		//return Input::all();
		
		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		
		try{
			if(Auth::attempt($user)){
				return Redirect::to('/');

			}else{
				return Redirect::to('/')->with(array(
						'status' => 401
					));
			}
		}catch(exception $e){
			return Redirect::to('/')->with(array(
						'status' => 401, 'error' => $e->getMessage()
					));
		}
	}

	public function postLogout() {

		Auth::logout();

		return Redirect::to('/')->with(array(
					'status' => 200, 'message' => 'logged out'
				));
	}

	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
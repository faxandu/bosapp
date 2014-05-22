<?php

class UserController extends BaseController {


	public function getCreate(){

		$this->layout->content = View::make('admin.user.create');
	
	}

	public function postCreate(){

		$input = Input::all();
		
		$input['password'] = Hash::make($input['password']);

		ControllerHelper::create(new User, $input, '/admin/user');

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

	public function get(){

		$this->layout->content = View::make('admin.user.home')->with(array(
			'users' => User::all()
			));

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
	
	public function login() {

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

	public function logout() {

		Auth::logout();

		return Redirect::to('/')->with(array(
					'status' => 200, 'message' => 'logged out'
				));
	}

	public function missingMethod($parameters = array()){
		return Response::json(array('status' => 404, 'message' => 'Not found'), 404);
	}
}
<?php

class ControllerHelper {


	public static function create($model, $input, $route_pass, $route_fail = null){

		if($route_fail == null)
			$route_fail = $route_pass;

		$checkedInput = $model::validate($input);

		if($checkedInput->fails()){

			return Redirect::to($route_fail)->with(array(
				'error' => $checkedInput->messages()->all()
			));
		
		}

		try{

			$model::create($input);

		} catch(Exception $e){

			return Redirect::to($route_fail)->with(array(
				'error' => $e->getMessage()
			));

		}

		/* Assumed all is well
		* * * * * * * * * * * * * * * * */
		return Redirect::to($route_pass);

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
	
	public function login() {
		
		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		
		try{

			if(Auth::attempt($user, false)){

				return Redirect::to('/')->with(array('alert' => array(
							'type' => 'alert-success',
							'msg' => 'logged in'
						)
					));
			
			}else{
			
				return Redirect::to('login')->with(array('alert' => array(
							'type' => 'alert-error',
							'msg' => 'Invalid username or password'
						)
					));
			
			}

		}catch(exception $e){

			return Redirect::to('login')->with(array('alert' => array(
							'type' => 'alert-error',
							'msg' => 'unexpected error'
						)
					));

		}
	}

	public function loginPage() {

		$this->layout->content = View::make('user.login');
		
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
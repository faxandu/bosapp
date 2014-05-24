<?php

class UserController extends BaseController {

	
	

	public function postCreate(){

		$input = Input::all();

		try{

			$input['password'] = Hash::make($input['password']);
			$this->layout->content = ControllerHelper::create(new User, $input, '/admin/user/home', '/admin/user/create');

		}catch(exception $e){

			$this->layout->content = Redirect::to('admin/user/create')->with(array(
				'error' => 'password required'));	
		
		}		

		return $this->layout->content;
	}

	public function postDelete(){

		$input = Input::all();

		try{

			User::findOrFail($input['id'])->delete();

			$this->layout->content = Redirect::to('admin/user/home')->with(array(
				'status' => 200,
				
				));

		}catch(exception $e){

			$this->layout->content = Redirect::to('admin/user/create')->with(array(
				'status' => 400,
				'error' => 'deletion failed'
				));	
		
		}		

			
		return $this->layout->content;


	}

	
	public function getHome(){

		$this->layout->content = View::make('admin.user.home')->with(array(
			'users' => User::all()
			));

	}

	public function getCreate(){

		$this->layout->content = View::make('admin.user.create')->with(Session::all());
	
	}


	
	
	public function login() {

		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		
		try{


			if(Auth::attempt($user)){

				return Redirect::to('/')->with(array(
					'status' => 200
					));
			
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

		//Should not reach this point
		return "Fatal Error";
	}

	public function logout() {

		Auth::logout();

		return Redirect::to('/')->with(array(
					'status' => 200, 
					'message' => 'logged out'
				));
	}
}
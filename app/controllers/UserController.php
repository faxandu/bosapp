<?php


class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Controller Views
	|--------------------------------------------------------------------------
	*/
	
	public function getHome(){

		$this->layout->content = View::make('admin.user.home')->with(array(
			'users' => User::all()
			));

	}

	public function getCreate(){

		$this->layout->content = View::make('admin.user.create')->with(Session::all());
	
	}


	/*
	|--------------------------------------------------------------------------
	| Controller Posts
	|--------------------------------------------------------------------------
	*/

	public function postCreate(){

		$input = Input::all();

		try{

			$input['password'] = Hash::make(str_random(10));
			$this->layout->content = ControllerHelper::create(new User, $input, '/admin/user/home', '/admin/user/create');

		}catch(exception $e){

			$this->layout->content = Redirect::to('admin/user/create')->with(array(
				'error' => 'password required'));	
		
		}		

		return $this->layout->content;
	}

	public function getDelete($id){

		try{


			$person = User::findOrFail($id)->delete();

			$this->layout->content = Redirect::to('admin/user/home')->with(array(
				'status' => 200,
				'alert' => 'success',
				'message' => 'User Deleted',
				
				));

		}catch(exception $e){

			$this->layout->content = Redirect::to('admin/user/home')->with(array(
				'status' => 400,
				'alert' => 'danger',
				'message' => 'User Deletion Failed',
				));	
		}		
			
		return $this->layout->content;

	}

	//function to enable or disable a user
	public function getDisable($id){

		$user = User::find($id);

		if ($user->active == '1')
		{
			$user->active = 0;
			$message = "Account Disabled";
		}
		else
		{
			$user->active = 1;
			$message = "Account Enabled";
		}
		$user->save();
		return Redirect::back()->with('message',$message);
		
	}

	public function login() {

		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		$allow = User::where('username', '=', Input::get('username'))->get();

		if ($allow[0]['active'] == 0)
			return Redirect::back()->with('message','Account is Disabled');

		//echo '<pre>' . $allow[0]['active']; exit; //print_r($allow); exit;
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

	public function passwordRecovery() {
		
		$user = User::where('username', Input::get('username'))->firstOrFail();

		$user->reset_token = str_random(10);

		$user->save();
		Mail::send('emails.password', $user->toArray(), function($message) use ($user) {
			$message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('BOSApp Password Recovery');
		});

		return Redirect::to('/')->with(array('message' => 'Password Recovery Email Sent'));
		
	}

	public function passwordResetForm($token) {

		$this->layout->content = View::make('user/passwordReset', array('token' => $token));
	}

	public function passwordReset() {
		$input = Input::all();

		if ($input['password'] === $input['vpassword']) {
			$user = User::where('reset_token', $input['token'])->firstOrFail();
			$user->password = Hash::make($input['password']);
			$user->reset_token = null;
			$user->save();
			return Redirect::to('/')->with(array('message' => 'Your password has been reset. You may now log in'));
		} else {
			return Redirect::to('/passwordReset/'.$input['token'])->with(array('message' => 'Passwords do not match'));
		}
	}


}

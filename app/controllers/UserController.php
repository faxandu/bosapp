<?php

class UserController extends BaseController {

	public function delete(){
		
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

	public function getEntry(){
		
		try{	

			$id = Input::get('id');
			$user =  User::findOrFail($id);
			$userArr['entries'] = $user->entries->toarray();
			return Response::json($userArr);

		}catch(exception $e){
			return Response::json(array('status' => 400, 	
			'message' => 'Failed to get user.', 'error' => $e->getMessage()), 400);
		}		
	}


	public function set(){
		

		if(Input::has('name')){
			$input = Input::all();
			//update or create
			//************************ update currently wipes old data 
			$user = (Input::has('id')) ? User::find(Input::get('id'))->update($input) : User::create($input);

			return Response::json(array("response" => "created"));
		}
		app::abort(400);
	}





}
<?php 

namespace Lotto\controllers;

use Lotto\models\Availability, User;
use Input, Response, Auth, Exception;
use View, Redirect;


/*
	Sets the data in a new row in the models table if validation passes

	All variables with the redirect are accessed by Session::get();
----------------------------- */
class HelperController {

	public static function create($model, $input, $route_pass, $route_fail = "/"){

	
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

		/* Assume all is good
		* * * * * * */
		return Redirect::to($route_pass)->with(array(
				'status' => 'created'
			));

	}

}

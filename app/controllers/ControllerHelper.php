<?php

class ControllerHelper {


	public static function create($model, $input, $route_pass, $route_fail = null){

		if($route_fail == null)
			$route_fail = $route_pass;

		$checkedInput = $model::validate($input);

		if($checkedInput->fails()){

			return Redirect::to($route_fail)->with(array(
				'status' => 400,
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

		return Redirect::to($route_pass)->with(array(
				'status' => 200
			));;

	}




}
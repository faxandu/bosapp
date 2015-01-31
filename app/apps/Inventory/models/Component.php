<?php

namespace Inventory\models;
use Input, User, Response, Eloquent, Validator;


use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Component extends Eloquent{

	protected $table = 'inventory_component';
	protected $fillable = array('equipment_id', 'model', 'type', 'storage', 'memory', 'location');
	protected $guarded = array('id');
	public $timestamps = false;

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */

	public function entry(){
		return $this -> belongsTo('Equipment');
	}

	private static $rules = array(
		'equipment_id' => 'numeric',
		'location' =>	'required|alpha_num_spaces',
		'model' =>	'required|alpha_num_spaces',
		'type' =>	'required|alpha_num_spaces',
		'storage' =>	'alpha_num_spaces',
		'memory' =>    'alpha_num_spaces'
		);

	public static function validate($date){
		return Validator::make($data, static::$rules);
	}
}

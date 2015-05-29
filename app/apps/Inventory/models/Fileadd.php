<?php

namespace Inventory\models;
use Input, User, Response, Eloquent, Validator;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Fileadd extends Eloquent{

	protected $table = 'inventory_fileadd';

	protected $fillable = array('equipment_id', 'name', 'notes');
	protected $guarded = array('id');
	public $timestamps = false;

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */

	public function entry(){
		return $this -> belongsTo('Inventory\models\Equipment');
	}

	private static $rules = array(
		'equipment_id' => 'required|numeric',
		'name' => 'alpha_num_spaces',
		'notes' => 'alpha_num_spaces'
		);

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}
}

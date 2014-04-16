<?php

namespace Inventory\models;
use Input, User, Response, Eloquent, Validator;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Contract extends Eloquent{

	protected $table = 'inventory_contract';

	protected $fillable = array('equipment_id', 'type', 'expiration', 'contract_number', 'vendor', 'contact_info');
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

		'type' =>	'required|alpha_num_spaces',
		'expiration' =>	'required|date',
		'contract_number' =>	'required|alpha_num',
		'vendor' =>	'required|alpha_num_spaces',
		'contact_info' => 'alpha_num_spaces'
		);

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}
}
<?php

namespace Inventory\models;
use Input, User, Response, Eloquent;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Contract extends Eloquent{

	protected $table = 'inventory_contract';
	protected $fillable = array('equipment_id', 'type', 'expiration', 'contract_number', 'vendor');
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


}
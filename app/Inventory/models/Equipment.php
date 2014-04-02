<?php

namespace Inventory\models;
use Input, User, Response, Eloquent;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Equipment extends Eloquent{

	protected $table = 'inventory_equipment';
	protected $fillable = array('id', 'manufacturer', 'model', 'location', 'obtained', 'warranty');
	public $timestamps = false;
	public $incrementing = false;
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */

	public function contract(){
		return $this -> hasMany('Contract');
	}

	public function component(){
		return $this -> hasMany('Component');
	}
}
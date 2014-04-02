<?php

namespace Inventory\models;
use Input, User, Response, Eloquent;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Component extends Eloquent{

	protected $table = 'inventory_component';
	protected $fillable = array('equipment_id', 'model', 'type', 'storage', 'memory');
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
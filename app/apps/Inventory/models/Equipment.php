<?php

namespace Inventory\models;
use Input, User, Response, Eloquent, Validator;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Equipment extends Eloquent{

	protected $table = 'inventory_equipment';
	protected $fillable = array('serial_number', 'manufacturer', 'model', 'location', 'obtained', 'warranty', 'type');
	protected $guarded = array('id');
	public $timestamps = false;
	public $incrementing = false;
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */

	public function contract(){
		return $this -> hasMany('Inventory\models\Contract');
	}

	public function component(){
		return $this -> hasMany('Inventory\models\Component');
	}

	public function fileadd(){
		return $this -> hasMany('Inventory\models\Fileadd');
	}

	private static $rules = array(
		'serial_number' => 'required|alpha_num',
		'manufacturer' =>	'required|alpha_num_spaces',
		'type' => 'required|alpha',
		'model' =>	'alpha_num_spaces',
		'location' =>	'required|alpha_num_spaces',
		'obtained' =>	'date',
		'warranty' =>    'date'
		);

	public static function validate($data){
		return Validator::make($data, static::$rules);
	}
}

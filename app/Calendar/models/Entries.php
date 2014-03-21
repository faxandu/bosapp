<?php
namespace Calendar\models;
use BaseController, Eloquent;

class Entries extends Eloquent {

	protected $table = 'cal_entries';
	public $timestamps = true;
	protected $guarded = array('id');
    protected $hidden = array('pivot','created_at', 'updated_at');

}
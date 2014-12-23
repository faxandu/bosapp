<?php

class AdminOptions extends Eloquent {

	protected $table = 'admin_options';
	public $timestamps = false;
	protected $fillable = array('availability_lock');
	protected $guarded = array('id');

}


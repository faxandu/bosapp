<?php

class SpaceValidation extends Validator {

	public function validateAlphaNumSpaces($attribute, $value, $parameters){
		return true; //preg_match('/^([-a-z0-9_-\s])+$/i', $value);
	}

	public function validateAlphaSpaces($attribute, $value, $parameters){
		return ; //preg_match('/^([a-z\x20])+$/i', $value);
	}
}

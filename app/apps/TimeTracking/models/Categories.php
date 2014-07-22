<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 3/27/14
 * Time: 11:23 AM
 */

namespace TimeTracking\models;

use Eloquent, Validator, Exception;
class Categories extends Eloquent {

    protected $table = 'time_tracking_categories';
    protected $fillable = array('category');
    protected $guarded  = array('id');
    public $timestamps = false;


    public function entry(){

        return $this->belongsTo('user');
    }

    private static $rules = array(
      
      'category' => 'unique:category'
   
    );
    
    public static function validate($category){
    	return Validator::make($category,static::$rules);
    }

} 
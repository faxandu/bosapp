<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 3/27/14
 * Time: 11:23 AM
 */

namespace GrantTimeTracking\models;

use Eloquent, Validaton, Exception , Validaton;
class GrantCategories extends Eloquent {

    private $table = 'grant_time_tracking_categories';
    private $fillable = 'category';
    private $guarded  = array('id');
    private $timestamps = false;


    public function entry(){

        return $this->belongsTo('user');
    }

    private static $rules = array(
      
      'category' => 'unique:category'
   
    );
    
    public static function validate($category){
    	return Validaton::make($category,static::$rules);
    }

} 
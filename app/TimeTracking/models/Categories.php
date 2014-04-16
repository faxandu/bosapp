<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 3/27/14
 * Time: 11:23 AM
 */

namespace TimeTracking\models;

use User;
class Categories extends Eloquent {

    private $table = 'categories_table';
    private $fillable = 'choices';
    private $guarded  = array('id');
    private $timestamps = false;


    public function entry(){
        return $this->belongsToMany('Entry','entry_category');
    }

} 
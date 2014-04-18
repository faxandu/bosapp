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

    private $table = 'time_tracking_categories_table';
    private $fillable = 'category';
    private $guarded  = array('id');
    private $timestamps = false;
    private $created = false;

    public function entry(){

        if(!$this->created)
            $this->postCreate();

        return $this->belongsTo('user');
    }

    public function postCreate(){

        $categories = array('lab_aide', 'lab_tech', 'facilitator' ,'time_tracking'
                            ,'group_study' ,'lotto','project_management','grant','meeting');
        $array = array();

        foreach($categories as $category){
            $array['category'] = $category;
        Categories::create($array);
        }
        $this->created = true;
    }
} 
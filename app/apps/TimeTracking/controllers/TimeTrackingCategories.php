<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 10:25 PM
 */

namespace TimeTracking\controllers;


use Illuminate\Support\Facades\Input;
use BaseController, User,  Entry ,Response;
use TimeTracking\models\Categories;

class TimeTrackingCategories extends BaseController{


    public function postAddCategory(){

        $input = Input::all();
        $temp = Categories::validate($input['category'])

        if(!$temp->fails()){

            $category = new Categories();
            try
            {
                $category['category'] = $input['category'];
                $category->save();
                Response::json(array('status' => 200, 'message' => 'category added'), 200);
            }
            catch (exception $e)
            {
                Response::json(
                    array('status' => 401, 'message' => 'category not saved ' , 'error' => $e), 401);
            }
        }
        else
            Response::json(
                array('status' => 401, 'message' => 'category already exists '), 401);
    }

    public public function postDeleteCategory(){
        
        $input = Input::all();
        $category = Categories::find($input['id']);
        try {
             $category->delete();
             Response::json(
                array('status' => 200 'message' => 'successful deletion') , 200);
        } catch (exception $e) {
                 Response::json(
                    array('status' => 401, 'message' => 'deletion failed' , 'error' => $e), 401);
        }
    }

    public function postEditCategory(){

        $input = Input::all();
        $category = Categories::find($input[id]);
        try
        {
            $category['category'] = $input['category'];
            $category->save();
            Response::json(array('status' => 200 , 'message' =>'category updated' ) , 200);
        }
        catch (exception $e)
        {
            Response::json(array('status' => 401 , 'message' => 'edit failed ', 'error' => $e) ,401);
        }

    }

    public function getCategories(){


        $categories = Categories::all()->toArray();

        if($categories->count() > 0)
            Response::json($categories,200);
        else
            Response::json(
                array('status'=> 401 , 'message' => 'category does not exist'), 401);
    }

    private function failed($category){
        return Categories::validate($category)->fails();
    }
} 
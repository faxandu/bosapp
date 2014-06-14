<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 10:25 PM
 * This is the implementation for the model @see Categories.php
 * it makes it possible to create new catagories to be stored 
 * into the database.  
 * private functions will be located at the bottom.
 * 
 */

namespace TimeTracking\controllers;


use Illuminate\Support\Facades\Input;
use BaseController, User,  Entry ,Response, Redirect;
use TimeTracking\models\Categories;

class TimeTrackingCategories extends BaseController{

    /**
    * This function is used to add a category to the table. 
    * It will get input from the user and validate it from  
    * through a helper function ( @see failed($category) )
    * if the category is found to be unique it will 
    * then create an new object of Categories . 
    * If the object can not be saved for whatever reason it 
    * @throws exception 
    */
    public function postCreate(){

        $input = Input::all();
    
        if(!$this->failed($input)){

            $category = new Categories();
            try
            {
                $category['category'] = $input['category'];
                $category->save();
                //return Response::json(array('status' => 200, 'message' => 'category added'), 200);
                $this->layout->content = Redirect::to('/admin/payroll')->with(array('message' => 'Category Added', 'alert' => 'success'));
            }
            catch (exception $e)
            {
                //return Response::json(array('status' => 401, 'message' => 'category not saved ' , 'error' => $e), 401);
                $this->layout->content = Redirect::to('/admin/payroll')->with(array('message' => 'Category Creation Failed', 'alert' => 'danger'));
            }
        }
        else
            //return Response::json(array('status' => 401, 'message' => 'category already exists '), 401);
            $this->layout->content = Redirect::to('/admin/payroll')->with(array('message' => 'Category Creation Failed', 'alert' => 'danger'));
    }
    /*
    public function postAddCategory(){

        if(!$this->failed($Input::get())){
              Categories::create(Input::get());
        }
    }
    */
    
    /*
    public function postModify(){

        Categories::update(Input::get('id'));
    }
    */
    
    /**
    * This function will delete a category based upon a 
    * the id sent in from the user. If the category does not
    * exist it @throws exception 
    * 
    */
    public function postDeleteCategory(){
        
        
        $category = Categories::find(Input::get('id' ) );
        try {
             $category->delete();
             return Response::json(
                array('status' => 200, 'message' => 'successful deletion') , 200);
        } catch (exception $e) {
                 return Response::json(
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
            return Response::json(array('status' => 200 , 'message' =>'category updated' ) , 200);
        }
        catch (exception $e)
        {
            return Response::json(array('status' => 401 , 'message' => 'edit failed ', 'error' => $e) ,401);
        }

    }

    public function getCategories(){
          return  Response::json(
                array('category'=> Categories::all()->toArray() ));
    }
    /**
    * @link http://laravel.com/docs/validation 
    * Documentation for fails() function  
    */
    private function failed($category){
        //return Categories::validate($category)->fails();
    }
} 
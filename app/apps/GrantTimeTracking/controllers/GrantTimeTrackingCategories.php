<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 10:25 PM
 */

namespace GrantTimeTracking\controllers;


use Illuminate\Support\Facades\Input;
use BaseController, User,  Entry ,Response;
use TimeTracking\models\Categories;

class GrantTimeTrackingCategories extends BaseController{


    public function postCreate(){

            $input = Input::all();

            $category = new GrantCategories();
            try
            {
                $category['category'] = $input['category'];
                $category->save();
                $this->layout->content =
                Redirect::to('/admin/payroll')->with(array('message' => 'Category Added', 'alert' => 'success'));
            }
            catch (exception $e)
            {
              $this->layout->content = 
              Redirect::to('/admin/payroll')->with(array('message' => 'Category Creation Failed', 'alert' => 'danger'));
            }
        }
        
    }

    public public function postDeleteCategory(){
        
        $input = Input::all();
        $category = GrantCategories::find($input['id']);
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
        $category = GrantCategories::find($input[id]);
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
          return  Response::json(
                array('category'=> GrantCategories::all()->toArray() ));
    }

    private function failed($category){
        return Categories::validate($category)->fails();
    }
}
 
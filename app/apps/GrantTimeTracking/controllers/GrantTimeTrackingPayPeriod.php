<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 4/18/14
 * Time: 11:04 PM
 */

namespace GrantTimeTracking\controllers;

use BaseController, User,  Entry ,Response;

class GrantTimeTrackingPayPeriod extends BaseController{


    public function getIndex() {
        $this->layout->content = View::make('time/payperiod', array('pay_periods' => GrantTimeTrackingPayPeriod::all()));
    }

    public function index() {
        $this->layout->content = View::make('admin/time/payperiod', array('pay_periods' => GrantTimeTrackingPayPeriod::all()));
    }

	public function postCreatPayPeriod(){
   
    $pay_period = new GrantTimeTrackingPayPeriod();
    $this->postPayPeriod($pay_period);
      
	}

	public function postDeletePeriod(){

		$period = GrantTimeTrackingPayPeriod::find(Input::get('id'));
		try
		{
          $period->delete();
          Response::json(array('status' => 200, 'message' => 'deletion successful'), 200);
		}
		catch(exception $e)
		{
			Response::json(array('status' => 401, 'message' => 'deletion unsuccessful', 'error' => $e), 400);
		}

	}
    
	public function postModifyPeriod(){

		$period = GrantTimeTrackingPayPeriod::find(Input::get('id'));
		$this->postPayPeriod($period);

	}
    
    public function getPayPeriod(){
       return Response::json(array('pay_period' => , TimeTrackingPayPeriod::all()->toArray() ) );
    } 

    private function postPayPeriod($pay_period){

        
        if (!$this->failed(Input::all())) {
            $start_date = date("Y-n-j",strtotime(Input::get('start_pay_period')));
            $end_date = date("Y-n-j",strtotime(Input::get('end_pay_period')));
            
            try
            {
                $pay_period['name'] = Input::get('name');
                $pay_period['start_pay_period'] = $start_date;
                $pay_period['end_pay_period']   = $end_date;
                $pay_period->save();
                $this->layout->content = Redirect::to('admin/payroll')->with(array('message' => 'Pay Period Created', 'alert' => 'Success'));
            }
            catch(exception $e){
                $this->layout->content = Redirect::to('admin/payroll')->with(array('message' => 'Pay Period Creation Failed', 'alert' => 'danger'));
            }
        }
        else
            $this->layout->content = Redirect::to('admin/payroll')->with(array('message' => 'Pay Period Creation Failed', 'alert' => 'danger'));
    }
    
    private function failed($pay_period){
    	return GrantTimeTrackingPayPeriod::validate($pay_period)->fails();
    }

} 
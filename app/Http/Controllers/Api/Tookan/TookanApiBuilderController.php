<?php

namespace App\Http\Controllers\Api\Tookan;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Order;
use App\Customer;
use App\Address;


class TookanApiBuilderController extends Controller
{
	private $tookan;

	public function createTask(Order $order){

		//dd($order);

		$customer = $order->customer;
		$address = $order->address;
		$delivery_date = explode(' ',$order->created_at);

		if(isset($customer->delivery_prefer_time) && $customer->delivery_prefer_time!='' && $customer->delivery_prefer_time!=null){
			$delivery_time = $customer->delivery_prefer_time;
		}else{
			$delivery_time = $delivery_date[1];
		}

		//Default Team id
		$team_id = "17287";

		$zone_id = $address->zone->id ;
		$mapping = Config::get('tookan.mapping');
		foreach($mapping as $key => $value){
			$zone_ids = explode(',',$value);

			if(in_array($zone_id,$zone_ids)){
				$team_id = $key;
			}
		}
		

		$full_name = $customer->first_name.' '.$customer->last_name;
		$address = $address->getFullAddress().', India';
		$data = array(
			"order_id" => $order->id,
			"job_description" => "Grocerices Devlivery",
			"customer_email" => $customer->email,
			"customer_username" => $full_name,
			"customer_phone" =>  '+91'.$customer->contact_no,
			"customer_address" => "$full_name, $address",
			"latitude" => "",
			"longitude" => "",
			"job_delivery_datetime" => $delivery_date[0].' '.$delivery_time,
			"team_id" => "$team_id"
			);

		//dd($data);	
		$response = $this->tookan->createTask($data) ;

		//dd($response);

		if($response['status'] == 200){

			return $response['data'];
		}

		
	}

	public function getTaskByOrderId($order_id){

		$response = $this->tookan->getTaskByOrderId($order_id);

		return $response;
		//dd($response);
	}

	public function deleteTaskByORderId($order_id){

		$response = $this->tookan->deleteTask($order_id);
	}


	public function editTask(Order $order){

		$customer = $order->customer;
		$address = $order->address;
		$delivery_date = explode(' ',$order->created_at);

		if(isset($customer->delivery_prefer_time) && $customer->delivery_prefer_time!='' && $customer->delivery_prefer_time!=null){
			$delivery_time = $customer->delivery_prefer_time;
		}else{
			$delivery_time = $delivery_date[1];
		}

		//Default Team id
		$team_id = "17287";

		$zone_id = $address->zone->id ;
		$mapping = Config::get('tookan.mapping');
		foreach($mapping as $key => $value){
			$zone_ids = explode(',',$value);

			if(in_array($zone_id,$zone_ids)){
				$team_id = $key;
			}
		}
		

		$full_name = $customer->first_name.' '.$customer->last_name;
		$address = $address->getFullAddress().', India';

		$task_response = $this->getTaskByOrderId($order->id);

		//dd($task_response);

		if(isset($task_response['status']) && $task_response['status'] == 200){


			foreach ($task_response['data'] as $task) {
					$job_id = $task->job_id;
			}

			$data = array(
			"job_id" => $job_id,
			"job_description" => "Grocerices Devlivery",
			"customer_email" => $customer->email,
			"customer_username" => $full_name,
			"customer_phone" =>  '+91'.$customer->contact_no,
			"customer_address" => "$full_name, $address",
			"latitude" => "",
			"longitude" => "",
			"job_delivery_datetime" => $delivery_date[0].' '.$delivery_time,
			"team_id" => "$team_id"
			);

			//dd($data);	
			$response = $this->tookan->editTask($data) ;


		}

		//return $response;

		
	}

	public function __construct(){

		$this->tookan  = new TookanApiController;
	}
}
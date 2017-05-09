<?php

namespace App\Http\Controllers\Api\Tookan;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;


class TookanApiController extends Controller
{
	private $api_key ;
	private $user_id ;
	private $api_base_url ;
	private $api_version ;

	public function __construct(){

		$this->api_key = Config::get('tookan.api_key');
		$this->user_id = Config::get('tookan.user_id');
		$this->api_base_url = Config::get('tookan.api_base_url');
		$this->api_version = Config::get('tookan.api_version');

	
	}

	public function getBaseUrl(){
		$base_path =  $this->api_base_url;
		$base_path .=  '/'.$this->api_version;

		return $base_path;
	}

	public function callApi($url,$headers,$data){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


		$output = curl_exec ($ch);
		//$info = curl_getinfo($ch);
		//$http_result = $info['http_code'];
		curl_close ($ch);

		$response = (array)(json_decode($output));

		return $response;

	}

	public function createTask($cust_data)
	{

		$url = $this->getBaseUrl().'/create_task';

		$data = array("api_key" => $this->api_key,
			"custom_field_template" => "Template 1",
			"meta_data" => [
				array("label"=>"Price","data" =>"100"),
				array("label"=>"Price","data" =>"100")
			],
			
			"auto_assignment" => "0",
			"has_pickup" => "0",
			"has_delivery" => "1",
			"layout_type"=>"0",
			"tracking_link" => 1,
			"timezone" => "+530",
			"fleet_id" => "",
			"ref_images" => [ "http://tookanapp.com/wp-content/uploads/2015/11/logo_dark.png",
    						  "http://tookanapp.com/wp-content/uploads/2015/11/logo_dark.png" ],
			"notify" => "1",
			"tags" => "",
			"geofence" => 0

			 ); 

		$data = array_merge($data,$cust_data);

		//dd($data);

		$data_string = json_encode($data);   

		/*echo '<pre>';
		print_r($data_string);
		echo '<pre>';
		*/
		//exit;

		$headers = array('Content-Type: application/json');
		
		$response  =  $this->callApi($url , $headers, $data_string) ;
		/*
				echo '<pre>';
				print_r($response);
				echo '<pre>';
		*/

		return $response;
		
	}

	public function getTaskByOrderId($order_id){

		$url = $this->getBaseUrl().'/get_task_details_by_order_id';

		$data = array("api_key" => $this->api_key,
				"order_id" => $order_id,
  				"user_id" => $this->user_id
		);

		$headers = array('Content-Type: application/json');
		$data_string = json_encode($data);

		$response  =  $this->callApi($url , $headers, $data_string) ;
		return $response;

	}

	public function deleteTaskByORderId($order_id){

		$url = $this->getBaseUrl().'/delete_task';

		//Get Job id from order_id 
		$task_response = $this->getTaskByOrderId($order_id);

		if(isset($task_response['status']) && $task_response['status'] == 200){

			foreach ($task_response['data'] as $task) {

				$data = array(
					"api_key" => $this->api_key,
					"job_id" => $task->job_id
				);

				$headers = array('Content-Type: application/json');
				$data_string = json_encode($data);

				$response  =  $this->callApi($url , $headers, $data_string) ;
			}
			
			

		}

		return $response;

		
	}

	public function editTask($cust_data){

		$url = $this->getBaseUrl().'/edit_task';

		$data = array("api_key" => $this->api_key,
			"custom_field_template" => "Template 1",
			"meta_data" => [
				array("label"=>"Price","data" =>"100"),
				array("label"=>"Price","data" =>"100")
			],
			
			"auto_assignment" => "0",
			"has_pickup" => "0",
			"has_delivery" => "1",
			"layout_type"=>"0",
			"tracking_link" => 1,
			"timezone" => "+530",
			"fleet_id" => "",
			"ref_images" => [ "http://tookanapp.com/wp-content/uploads/2015/11/logo_dark.png",
    						  "http://tookanapp.com/wp-content/uploads/2015/11/logo_dark.png" ],
			"notify" => "1",
			"tags" => "",
			"geofence" => 0

			 ); 

		$data = array_merge($data,$cust_data);
		$data_string = json_encode($data);   

		$headers = array('Content-Type: application/json');
		$response  =  $this->callApi($url , $headers, $data_string) ;

		return $response;

	}

}
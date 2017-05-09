<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use App\Order;
use App\OrderDetail;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use \stdClass;

class CustomerHistoryGeneralController extends Controller
{


		public function postCustomer(Request $request){


		$query = DB::table('customers')
				// ->join('customers','orders.customer_id','=','customers.id')
				 ->select('customers.id','customers.email','customers.first_name','customers.last_name');

		if($request->has('customer_id')){
			
			$query->where('customers.id','=',$request->get('customer_id'));
		}
		if($request->has('first_name')){

			$query->where('customers.first_name','=',$request->get('first_name'));
		}	
		if($request->has('last_name')){

			$query->where('customers.last_name','=',$request->get('last_name'));
		}
		if($request->has('email')){

			$query->where('customers.email','=',$request->get('email'));
		}

		/*if($request->has('customer_name')){
			$attr = explode( " ",trim($request->get('customer_name')) );

			$query->where('customers.first_name','like','%'.$attr[0].'%');
			$query->orWhere('customers.last_name','like','%'.$attr[1].'%');
		}*/
		
		$query->orderBy('customers.id','desc');

		$customers = $query->get();
		/*echo '<pre>';
		print_r($stocks);
		echo '</pre>';
		exit;*/
		//dd($stocks);
		//print_r( $addres->city );
		//dd( $stocks[0]->product->product_name);
		$iTotalRecords = count($customers);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$customer = $customers[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $customer->id,
		  $customer->first_name,
		  $customer->last_name,
		  $customer->email,
		  '<a href="'.route('customerHistory.show',$customer->id).'" class="btn btn-xs default">View</a>
		   ',
		);
		}

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
		$records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
		
	}
	// This function is used to dispaly will move in CustomerGeneral Controllers
	
	
}
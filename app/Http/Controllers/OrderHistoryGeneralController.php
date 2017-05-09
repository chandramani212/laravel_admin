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

class OrderHistoryGeneralController extends Controller
{


	public function postOrder(Request $request){


		$query = DB::table('orders')
				 ->join('customers','orders.customer_id','=','customers.id')
				 ->select('orders.id','orders.order_total','orders.created_at','customers.first_name','customers.last_name');

		if($request->has('order_id')){
			
			$query->where('orders.id','=',$request->get('order_id'));
		}
		if($request->has('order_total')){

			$query->where('orders.order_total','=',$request->get('order_total'));
		}	
		if($request->has('customer_id')){
			
			$query->where('customers.id','=',$request->get('customer_id'));

		}
		if($request->has('created_from') && $request->has('created_to')){
		
			$query->whereBetween('orders.created_at',[$request->get('created_from').' 00:00:00',$request->get('created_to').' 23:59:59']);
		}
		$query->orderBy('orders.id','desc');

		$orders = $query->get();
		/*echo '<pre>';
		print_r($stocks);
		echo '</pre>';
		exit;*/
		//dd($stocks);
		//print_r( $addres->city );
		//dd( $stocks[0]->product->product_name);
		$iTotalRecords = count($orders);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$order = $orders[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $order->id,
		  $order->order_total,
		  $order->first_name.' '.$order->last_name,
		  $order->created_at,
		  '<a href="'.route('orderHistory.show',$order->id).'" class="btn btn-xs default">View</a>
	
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

	

	public function index(){

		echo 'PAGE Not Found';
	}
	// This function is used to dispaly will move in CustomerGeneral Controllers
	
	
}
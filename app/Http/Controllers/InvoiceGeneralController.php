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

class InvoiceGeneralController extends Controller
{



	public function postOrder(Request $request){


		$query = DB::table('orders as o')
				 ->join('customers','o.customer_id','=','customers.id')
				 ->select('o.id','o.order_total','o.order_stage','o.created_at','customers.first_name','customers.last_name',
				 	 DB::raw('(select count(odc.id) as issue from order_detail_comments odc join order_details od on od.id = odc.order_detail_id where od.order_id = o.id and odc.comment_status in("ISSUE","REQUEST") group by o.id )as issue')
                    );

		if($request->has('order_id')){
			
			$query->where('o.id','=',$request->get('order_id'));
		}
		if($request->has('order_total')){

			$query->where('o.order_total','=',$request->get('order_total'));
		}	
		if($request->has('customer_id')){
			
			$query->where('customers.id','=',$request->get('customer_id'));

		}
		
		if ($request->has('created_from') && !$request->has('created_to')) {

            $query->whereBetween('o.created_at', [$request->get('created_from') . ' 00:00:00', $request->get('created_from') . ' 23:59:59']);
        }
        elseif ($request->has('created_from') && $request->has('created_to')) {

            $query->whereBetween('o.created_at', [$request->get('created_from') . ' 00:00:00', $request->get('created_to') . ' 23:59:59']);
        }

		if($request->has('order_stage')){
		
			$query->where('o.order_stage','=',$request->get('order_stage'));
		}

		$query->whereNull('o.deleted_at');  
		$query->orderBy('o.id','desc');

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

		if( $order->issue > 0 ){
           $issue_notif = '<span title="Invoice With issue or change Request" class="badge badge-danger pull-left">'.$order->issue.' </span>';
            }else{
                $issue_notif = ''; 
            }

		$lable_class = ($order->order_stage=='UPDATED')?'label-danger':'label-default';
		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $order->id,
		  $order->order_total,
		  $order->first_name.' '.$order->last_name,
		  '<span class="invoice-confirm label label-sm '. $lable_class.' ">'.
			$order->order_stage.'</span>',
		  $order->created_at,
		  '<a href="'.route('invoice.show',$order->id).'" class="btn btn-xs default">View</a>'.
		   '<a href="' . route('invoice.edit', $order->id) . '" class="btn btn-xs">'.
            $issue_notif .
           '&nbsp;&nbsp;Edit
           </a> 
		  
		   <a href="'.route('OrderGeneralExcel',$order->id).'" class="btn btn-xs default">Export</a> 
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


	
}
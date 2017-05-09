<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use DB;

class CustomerGeneralController extends Controller
{

	public function index(){

		echo 'PAGE Not Found';
	}
	// This function is used  will move in CustomerGeneral Controllers
	public function postAddress($id){
		
		$addressOption = null;
		$address = Customer::find($id)->address;
		//print_r( $addres->city );
		//dd($address);
		foreach ($address as $addres) {

			$city_name = isset($addres->city->city_name)?$addres->city->city_name:'';
			$locality_name = isset($addres->locality->locality_name)?$addres->locality->locality_name:'';
			$state_name = isset($addres->state->state_name)?$addres->state->state_name:'';

			$addressOption["$addres->id"] =  $addres->address_line1.' '.$addres->address_line2.' '.$addres->street.' '.$addres->pin_code.' '. $city_name.' '. $locality_name.' '. $state_name;
		}

		if($addressOption ==null){
			$addressOption = [];

		}

		return view('pages.customers.addressSelect',compact('addressOption'));
	}

	public function postDefaultorder($id,$addressId =0 ){

		$order = Customer::find($id)->defaultOrder;
		if($order!==null)
		{
			$orderDetails = $order->orderDetails;
			$customerId = $id;
			return view('pages.customers.defaultOrder',compact('orderDetails','customerId','addressId'));
		}else{

			echo 'NO_DEFAULT_ORDER';
		}

		//dd($orderDetails);


	}

	public function postSetdefaultorder($customerId,$orderId){

		$customerUpdate = [
            'default_order_id' => $orderId,
        ];

        $response = Customer::find($customerId)->update($customerUpdate);

        if($response){

        	echo 'SUCCESS';
        }
	}


	public function postCustomer(Request $request){


		$query = DB::table('customers')
				// ->join('customers','orders.customer_id','=','customers.id')
				 ->select('customers.id','customers.email','customers.first_name','customers.last_name');

		if($request->has('customer_id')){
			
			$query->where('customers.id','=',$request->get('customer_id'));
		}
		if($request->has('first_name')){

			$query->where('customers.first_name','like','%'.$request->get('first_name').'%');
		}	
		if($request->has('last_name')){

			$query->where('customers.last_name','like','%'.$request->get('last_name').'%');
		}
		if($request->has('email')){

			$query->where('customers.email','=',$request->get('email'));
		}

		/*if($request->has('customer_name')){
			$attr = explode( " ",trim($request->get('customer_name')) );

			$query->where('customers.first_name','like','%'.$attr[0].'%');
			$query->orWhere('customers.last_name','like','%'.$attr[1].'%');
		}*/

		$query->whereNull('customers.deleted_at');		
		$query->orderBy('customers.id','desc');

		//echo $query->toSql;

		//exit;

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
		  '<a href="'.route('customer.show',$customer->id).'" class="btn btn-xs default">View</a>
		   <a href="'.route('customer.edit',$customer->id).'" class="btn btn-xs green">Edit</a> 
		   <form style="float:right" action="'.route('customer.destroy',$customer->id).'" method="post" >
		   <input type="hidden" name="_method" value="DELETE" />
		   <input type="hidden" name="_token" value="'.csrf_token().'" />
		   <input type="submit" class="btn btn-xs red" value="Delete">
		   </form>
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


	public function getSearch(Request $request){
		
		$query = Customer::query();

		if($request->has('q')){
			$q = $request->get('q');
			if(is_numeric($q)){
				
				$query->where('id','=',$q);

			}else{
				
				$query->where(DB::raw('concat(TRIM(first_name)," ",TRIM(last_name))'),'like','%'.trim($q).'%');
			}
				

			$customers = $query->get(['id','first_name','last_name']);
		}

		if($request->has('initial_selected_id')){
			$q = $request->get('initial_selected_id');
			$query->where('id','=',$q);	

			$customers = $query->get(['id','first_name','last_name'])->first();
		}

		//$products = $query->get(['id','product_name']);
		
		//return $products;
		echo $customers->toJson();
	}
	

}
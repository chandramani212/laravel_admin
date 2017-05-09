<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\CustomerProductAttributePrice;
use App\CustomerProductAttributePriceDetail;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use Activity;
use Illuminate\Support\Facades\Auth;
use \stdClass;

class CustomerPriceGeneralController extends Controller {

    public $menu = 'Ecommerce';

    public function getDuplicate($id)
    {
        Activity::log('user at  create Customer specific price ', Auth::id());   
        //
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('create_order') ){

           $customerPrice = CustomerProductAttributePrice::find($id);
           $custPriceDetails = $customerPrice->priceDetails;

            $customers =  Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
            $customerOption[""] = 'Choose Customer';
            foreach ($customers as $customer) {
                $customerOption["$customer->id"] =  $customer->first_name.' '.$customer->last_name ;
            }
            //dd($customerOption);
             $menu = $this->menu;

            return view('pages.customerPrice.create',compact('custPriceDetails','customerOption','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');

    }

    public function postCustomerprice(Request $request) {


    $query = DB::table('customers as c')
                ->join('address as a','a.customer_id','=','c.id')
                ->join('customer_product_attribute_prices as cp','a.id','=','cp.address_id')
                ->join('locality as l','a.locality_id','=','l.id')
                ->join('city as ci','a.city_id','=','ci.id')
                ->join('state as s','a.state_id','=','s.id')
                 ->select('c.id','cp.id as cust_pap_id','c.email','c.first_name','c.last_name','a.id as address_id','a.address_line1','a.address_line2','a.street','a.pin_code','l.locality_name','ci.city_name','s.state_name');

        if($request->has('customer_id')){
            
            $query->where('c.id','=',$request->get('customer_id'));
        }
        if($request->has('first_name')){

            $query->where('c.first_name','like','%'.$request->get('first_name').'%');
        }   
        if($request->has('last_name')){

            $query->where('c.last_name','like','%'.$request->get('last_name').'%');
        }
        if($request->has('email')){

            $query->where('c.email','=',$request->get('email'));
        }

        /*if($request->has('customer_name')){
            $attr = explode( " ",trim($request->get('customer_name')) );

            $query->where('customers.first_name','like','%'.$attr[0].'%');
            $query->orWhere('customers.last_name','like','%'.$attr[1].'%');
        }*/
        $query->whereNull('a.deleted_at');   
        $query->whereNull('c.deleted_at');      
        $query->orderBy('c.id','desc');
        $query->groupBy('a.id');

       /* echo $query->toSql();

        exit;*/

        $customers = $query->get();
       /* echo '<pre>';
        print_r($customers);
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
          $customer->address_id,
          $customer->first_name,
          $customer->last_name,
          $customer->email,
          $customer->address_line1 . ' '. $customer->address_line2. ' '. $customer->street. ' '. $customer->pin_code. ' '. $customer->locality_name. ' '. $customer->city_name. ' '. $customer->state_name,
          '<a href="'.route('customerPrice.show',$customer->cust_pap_id).'" class="btn btn-xs default">View</a>
           <a href="'.route('customerPrice.edit',$customer->cust_pap_id).'" class="btn btn-xs green">Edit</a> 
           <form style="float:right" action="'.route('customerPrice.destroy',$customer->cust_pap_id).'" method="post" >
           <input type="hidden" name="_method" value="DELETE" />
           <input type="hidden" name="_token" value="'.csrf_token().'" />
           <input type="submit" class="btn btn-xs red" value="Delete">
           </form>
            <a href="'.url('customerPrice/general').'/duplicate/'.$customer->cust_pap_id.'" class="btn btn-xs blue">Duplicate</a> 
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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\PaymentReceipt;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use Activity;
use Illuminate\Support\Facades\Auth;
use \stdClass;

class PaymentReceiptGeneralController extends Controller {

    public $menu = 'Ecommerce';

    public function postPaymentreceipt(Request $request) {

    $query = DB::table('payment_receipt as pr')
                ->join('address as a','a.id','=','pr.address_id')
                ->join('customers as c','c.id','=','pr.customer_id')
                ->select('pr.id','pr.amount','c.email','c.first_name','c.last_name');


        if($request->has('receipt_id')){
            
            $query->where('pr.id','=',$request->get('receipt_id'));
        }
        if($request->has('customer_id')){
            
            $query->where('c.id','=',$request->get('customer_id'));
        }
        if($request->has('amount')){

            $query->where('pr.amount','=',$request->get('amount'));
        }   
        

        /*if($request->has('customer_name')){
            $attr = explode( " ",trim($request->get('customer_name')) );

            $query->where('customers.first_name','like','%'.$attr[0].'%');
            $query->orWhere('customers.last_name','like','%'.$attr[1].'%');
        }*/     
        $query->orderBy('pr.id','desc');

       /* echo $query->toSql();

        exit;*/

        $receipts = $query->get();
       /* echo '<pre>';
        print_r($customers);
        echo '</pre>';
        exit;*/
        //dd($stocks);
        //print_r( $addres->city );
        //dd( $stocks[0]->product->product_name);
        $iTotalRecords = count($receipts);
        $iDisplayLength = intval($request->get('length'));
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($request->get('start'));
        $sEcho = intval($request->get('draw'));

        $records = array();
        $records["data"] = array(); 

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for($i = $iDisplayStart; $i < $end; $i++) {
            $receipt = $receipts[$i];
        //$status = $status_list[rand(0, 2)];
        $id = ($i + 1);

        $records["data"][] = array(
          '<input type="checkbox" name="id[]" value="'.$id.'">',
          $receipt->id,
          $receipt->first_name.' '.$receipt->last_name,
          $receipt->amount,
          '<a href="'.route('paymentReceipt.show',$receipt->id).'" class="btn btn-xs default">View</a>
           <a href="'.route('paymentReceipt.edit',$receipt->id).'" class="btn btn-xs green">Edit</a> 
           <form style="float:right" action="'.route('paymentReceipt.destroy',$receipt->id).'" method="post" >
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

}

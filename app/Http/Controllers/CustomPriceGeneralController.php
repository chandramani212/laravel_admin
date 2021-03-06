<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\CustomPrice;
use App\CustomPriceList;
use App\CustomerCustomPrice;

use DB;
use Maatwebsite\Excel\Facades\Excel;
use \stdClass;

class CustomPriceGeneralController extends Controller {





    public function postCustomprice(Request $request) {


      $query = DB::table('custom_prices as cp')
                //->join('custom_price_list as cpl','cpl.custom_price_id','=','cp.id')
                ->join('customer_custom_prices as ccp','ccp.custom_price_id','=','cp.id')
                ->join('customers as c','c.id','=','ccp.customer_id')
                ->select(DB::raw('cp.id,GROUP_CONCAT(CONCAT(c.first_name," ",c.last_name)) as customers,cp.description'));

        if($request->has('custom_price_id')){
            
            $query->where('cp.id','=',$request->get('custom_price_id'));
        }

        if($request->has('description')){
            
            $query->where('cp.description','like','%'.$request->get('description').'%');
        }

        if($request->has('customer_id')){
            
            $query->where('c.id','=',$request->get('customer_id'));
        }
       

        /*if($request->has('customer_name')){
            $attr = explode( " ",trim($request->get('customer_name')) );

            $query->where('customers.first_name','like','%'.$attr[0].'%');
            $query->orWhere('customers.last_name','like','%'.$attr[1].'%');
        }*/ 
        $query->orderBy('cp.id','desc');
        $query->groupBy('cp.id');

       /* echo $query->toSql();

        exit;*/

        $customePrices = $query->get();
       /* echo '<pre>';
        print_r($customers);
        echo '</pre>';
        exit;*/
        //dd($stocks);
        //print_r( $addres->city );
        //dd( $stocks[0]->product->product_name);
        $iTotalRecords = count($customePrices);
        $iDisplayLength = intval($request->get('length'));
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($request->get('start'));
        $sEcho = intval($request->get('draw'));

        $records = array();
        $records["data"] = array(); 

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for($i = $iDisplayStart; $i < $end; $i++) {
            $customePrice = $customePrices[$i];
        //$status = $status_list[rand(0, 2)];
        $id = ($i + 1);

        $records["data"][] = array(
          '<input type="checkbox" name="id[]" value="'.$id.'">',
          $customePrice->id,
          $customePrice->description,
          $customePrice->customers,
          '<a href="'.route('customPrice.show',$customePrice->id).'" class="btn btn-xs default">View</a>
           <a href="'.route('customPrice.edit',$customePrice->id).'" class="btn btn-xs green">Edit</a> 
           <form style="float:right" action="'.route('customPrice.destroy',$customePrice->id).'" method="post" >
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

    public function postUpdatelist(Request $request, $id){

       $customPriceListUpdate = [
            'product_id' =>  $request->get('product_id'),
            'attribute_id' =>  $request->get('attribute_id'),
            'price' =>  $request->get('price'),
            'default_selected_price' =>  $request->get('default_selected_price')
        ];

       // $id  = $request->get('id');

        $customPriceUpdate = CustomPriceList::find($id)->update($customPriceListUpdate);
        if($customPriceUpdate){
          echo 'SUCCESS';
        }else{
          echo 'FAIL';
        }
    }


    public function postDeletelist($id){

       $customPriceDelete =  CustomPriceList::find($id)->delete();

        if($customPriceDelete){
          echo 'SUCCESS';
        }else{
          echo 'FAIL';
        }
    }

    public function postAddlist(Request $request){

       $customPriceInsert = [
            'custom_price_id' =>  $request->get('custom_price_id'),
            'product_id' =>  $request->get('product_id'),
            'attribute_id' =>  $request->get('attribute_id'),
            'price' =>  $request->get('price'),
            'default_selected_price' =>  $request->get('default_selected_price')
        ];

        $customPriceList = CustomPriceList::create($customPriceInsert);

        if($customPriceList){
          echo 'SUCCESS';
        }else{
          echo 'FAIL';
        }
    }



}

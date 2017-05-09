<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class ProductAttributePriceGeneralController extends Controller
{

	public function index(){

		echo 'PAGE Not Found';
	}
	// This function is used  will move in CustomerGeneral Controllers
	public function postHistory(Request $request,$attributeId)
    {

		$query = DB::table('product_attribute_price_histories')
				 ->join('product_attributes','product_attribute_price_histories.attribute_id','=','product_attributes.id')
				 ->join('products','product_attributes.product_id','=','products.id')
				 ->join('users','product_attribute_price_histories.edited_by','=','users.id')
				 ->select('product_attribute_price_histories.price','product_attribute_price_histories.sale_price','product_attributes.attribute_name','product_attributes.uom','products.product_name','users.name','product_attribute_price_histories.updated_at');

		if(isset($attributeId)){
			
			$query->where('product_attributes.id','=',$attributeId);
		}

		if($request->has('price')){
			
			$query->where('product_attribute_price_histories.price','=',$request->get('price'));
		}
		if($request->has('sale_price')){

			$query->where('product_attribute_price_histories.sale_price','=',$request->get('sale_price'));
		}
		
		if($request->has('updated_by')){

			$query->where('users.name','like','%'.$request->get('updated_by').'%');
		}	

		$priceHistory = $query->get();


		/*echo '<pre>';
		print_r($priceHistory);
		echo '</pre>';
		exit;*/

		$iTotalRecords = count($priceHistory);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$history = $priceHistory[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $history->price,
		  $history->sale_price,
		  $history->product_name,
		  $history->attribute_name.' '. $history->uom ,
		  $history->name,
		  $history->updated_at,
		  '',
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\product ;
use DB;


class ProductGeneralController extends Controller
{

	public function index(){

		echo 'PAGE Not Found';
	}
	// This function is used  will move in CustomerGeneral Controllers
	public function getSearch(Request $request){
		
		$query = Product::query();

		if($request->has('q')){
			$q = $request->get('q');
			if(is_numeric($q)){
				
				$query->where('id','=',$q);

			}else{

				$query->where('product_name','like','%'.$q.'%');	
			}
				

			$products = $query->get(['id','product_name']);
		}

		if($request->has('initial_selected_id')){
			$q = $request->get('initial_selected_id');
			$query->where('id','=',$q);	

			$products = $query->get(['id','product_name'])->first();
		}

		//$products = $query->get(['id','product_name']);
		
		//return $products;
		echo $products->toJson();
	}

	//$id is productid $selectedid is used to dispaly attribute selected is used when we get defualt orders of customer
	public function postAttribute($id,$selectedid = 0,$customerId,$addressId =0 ){

		//echo $id;
		$response= array();
		
		$attributes = product::find($id)->attributes;

		if($attributes!==null){
			//dd($attributes);
			$i=0;
			$attributeContro = new AttributeGeneralController();
			

			foreach ($attributes as $attribute) {
				if($i==0){
					$all_price = $attributeContro->postAllprice($attribute->id,$customerId,$addressId);
					$selectedid = $attribute->id;
					$selected_attr_name = $attribute->attribute_name.' '.$attribute->uom;
				}
				$attributeOption["$attribute->id"] =  $attribute->attribute_name.' '.$attribute->uom;

				$i++;
			}

			//dd($attributes);

			$returnView = (string) view('pages.products.attributeSelect',compact('attributeOption','selectedid'));
			$response['view'] =htmlspecialchars($returnView);
			$response['price'] = json_decode($all_price);
			$response['default_attr_name'] = $selected_attr_name;
			$response['error_code'] = '0';
			$response['error_msg'] = 'success';
		
		}else{

			$response['error_code'] = '1';
			$response['error_msg'] = 'No Attribute';

		}

		return json_encode($response);;
	}
	
	public function postUpdateproductcategory(Request $request){
		
		echo $request->get('category_id');
		echo $request->get('product_id');
		
		DB::table('products')
            ->where('id', $request->get('product_id') )
            ->update(['category_id' => $request->get('category_id')]);
		//print_r($request);
		
		
	}

}
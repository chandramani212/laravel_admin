<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\product as Product;
use App\product_attribute as ProductAttribute;
use App\Customer;
use App\Address;
use App\CustomerProductAttributePrice;
use App\CustomerProductAttributePriceDetail;
use App\OrderDetail;
use App\Stock;
use DB;

class AttributeGeneralController extends Controller
{

	public function index(){

		echo 'PAGE Not Found';
	}

	public function postAllprice($attribute_id,$customer_id = 0 ,$address_id =0){

		//echo "Attribute id:".$attribute_id;
		$productAttribute = ProductAttribute::find($attribute_id);
		if($productAttribute!==null){


			
		
		$prices = $productAttribute->price()->get(['product_id','price','sale_price'])->first();
		
		//dd($prices);
		$stock = Stock::where('attribute_id','=',$attribute_id)->where('product_id','=',$prices->product_id)->get(['total_qty_in_hand'])->first();
		//dd($stock);

		$merchantPrice = '';
		if($customer_id > 0)
		{
			//echo 'Customer:'.$customer_id;
			$customer = Customer::find($customer_id)->get(['id'])->first();
			$address = Address::where('id',$address_id)->get(['id'])->first();
			//dd($address);
			if($address){
				//echo $attribute_id ; exit;
		
				/*$customerPrice = DB::table('customer_product_attribute_prices as cpap')
						->join('customer_product_attribute_price_details as cpapd','cpap.id','=','cpapd.customer_pap_id')
						->select('cpapd.id','cpapd.price','cpapd.default_selected_price')
						->where('customer_id','=',$customer_id)
						->where('address_id',$address_id)
						->where('attribute_id',$attribute_id)
						->get();
						*/

				$customerPrice = DB::table('custom_prices as cp')
						->join('custom_price_list as cpl','cpl.custom_price_id','=','cp.id')
						->join('customer_custom_prices as ccp','ccp.custom_price_id','=','cp.id')
						->select('cp.id','cpl.price','cpl.default_selected_price')
						->where('ccp.customer_id','=',$customer_id)
						->where('ccp.address_id',$address_id)
						->where('cpl.attribute_id',$attribute_id)
						->get();

				$customerPrice = isset($customerPrice[0])?$customerPrice[0]:null;

			}
			
			$orders = $customer->orders()->orderBy('id','DESC')->get();
			/*echo '<pre>';
			print_r($orders);
			echo '</pre>';*/
			
			/*
			foreach($orders as $order) {
				
				$merchant_prices = 	$order->orderDetails()->where('attribute_id','=',$attribute_id)->get(['actual_mrp','change_mrp'])->first();

				
				if($merchant_prices!==null){
					 $merchantPrice =  $merchant_prices->actual_mrp;
					break;
				}

			
			}
	*/

		}

		//foreach ($prices as $price) {

			$priceOption["price"] =  $prices->price;
			$priceOption["sell_price"] =  $prices->sale_price;
			$priceOption["specific_price"] =  isset($customerPrice->price)?$customerPrice->price:0;
			//$priceOption["custom_price"] =  isset($customerPrice->custom_price)?$customerPrice->custom_price:0;
			$priceOption["default_customer_specific_price"] =  isset($customerPrice->default_selected_price)?$customerPrice->default_selected_price:0;
			//$priceOption["merchant_price"] =  $merchantPrice;
			$priceOption["qty_in_hand"] =  isset($stock->total_qty_in_hand)?$stock->total_qty_in_hand:0;

			//break;
		//}
			
		}else{
			
			$priceOption["price"] =  0;
			$priceOption["sell_price"] =  0;
			$priceOption["specific_price"] =  0;
			//$priceOption["custom_price"] = 0;
			$priceOption["default_customer_specific_price"] = 0;
			//$priceOption["merchant_price"] =  0;
			$priceOption["qty_in_hand"] =  0;
			
		}
		
		return json_encode($priceOption);

		//dd($attributes);

		//return $prices->toJson();
		
	}

}
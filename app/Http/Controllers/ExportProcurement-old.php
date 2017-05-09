<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel; // excel export purpose
use App\Order;
use App\OrderDetail;
use DB;
class ExportProcurement extends Controller
{
    //
     public $menu = 'Product';
	public function index()
	{
		
		return view('procurement.exportprocurement',compact('menu'));
	}

	public function export_procurement(Request $request)
	{
		 $date = $request->get('procurementdate');
		
		 $date = $newDate = date("Y-m-d", strtotime($request->get('procurementdate')));
		
		//$order_details= OrderDetail::whereDate('created_at', '>=', $date)->toSql();

		/*$order_details =	DB::table('OrderDetails')
            ->join('stocks', 'OrderDetails.attribute_id', '=', 'stocks.attribute_id')
            ->whereDate('OrderDetails.created_at', '>=', $date)
            ->select('OrderDetails.product_name','sum(OrderDetails.qty)','stocks.total_qty_in_hand')
            ->lists('sum','OrderDetails.qty')
            ->groupBy('OrderDetails.attribute_id')
            ->toSql();
*/
          $order_details =  OrderDetail::groupBy('attribute_id')
   							->whereDate('order_details.created_at', '=', $date)
   							->selectRaw('product_name as productName,actual_attribute_name as attribute,actual_uom as uom, sum(qty) as totalQty')
   							->get();


$order_details = $order_details->toArray();

		//dd($order_details->toArray());
$file_name = "procurement_details" . date('Y-m-d');
		Excel::create($file_name, function($excel) use($order_details) {

   			$excel->sheet('Procurement', function($sheet) use($order_details){

        		$sheet->fromArray($order_details);

   			 });

		})->export('csv');

		  return redirect()->route('exportprocurement')->with('status', 'Succesfully download...!');
	}

}

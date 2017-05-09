<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Stock;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class StockGeneralController extends Controller
{

	public function index(){

		echo 'PAGE Not Found';
	}
	// This function is used to dispaly will move in CustomerGeneral Controllers
	public function postStock(Request $request){


		$query = DB::table('stocks')
				 ->join('products','stocks.product_id','=','products.id')
				 ->join('product_attributes','stocks.attribute_id','=','product_attributes.id')
				 ->select('stocks.*','products.product_name','product_attributes.attribute_name','product_attributes.uom');

		if($request->has('stock_id')){
			
			$query->where('stocks.id','=',$request->get('stock_id'));
		}
		if($request->has('total_qty_in_hand')){

			$query->where('total_qty_in_hand','=',$request->get('total_qty_in_hand'));
		}	
		if($request->has('product_name')){
			
			$query->where('products.product_name','like','%'.$request->get('product_name').'%');
		}
		if($request->has('attribute_name')){
			$attr = explode( " ",trim($request->get('attribute_name')) );

			$query->where('product_attributes.attribute_name','like','%'.$attr[0].'%');
			$query->orWhere('product_attributes.uom','like','%'.$attr[1].'%');
		}

		$stocks = $query->get();
		/*echo '<pre>';
		print_r($stocks);
		echo '</pre>';
		exit;*/
		//dd($stocks);
		//print_r( $addres->city );
		//dd( $stocks[0]->product->product_name);
		$iTotalRecords = count($stocks);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$stock = $stocks[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $stock->id,
		  $stock->total_qty_in_hand,
		  $stock->product_name,
		  $stock->attribute_name.' '.$stock->uom,
		  '<a href="'.route('stock.show',$stock->id).'" class="btn btn-xs default">View</a>
		   <a href="'.route('stock.edit',$stock->id).'" class="btn btn-xs green">Edit</a> 
		   <form style="float:right" action="'.route('stock.destroy',$stock->id).'" method="post" >
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


	public function postHistory(Request $request,$stockId){


		$query = DB::table('stock_history')
				 ->join('stocks','stock_history.stock_id','=','stocks.id')
				 ->join('users','stock_history.updated_by','=','users.id')
				 ->select('stocks.id','stock_history.basic_qty','users.name','stock_history.created_at');

		if(isset($stockId)){
			
			$query->where('stocks.id','=',$stockId);
		}

		if($request->has('stock_id')){
			
			$query->where('stocks.id','=',$request->get('stock_id'));
		}
		if($request->has('total_qty_in_hand')){

			$query->where('stock_history.basic_qty','=',$request->get('total_qty_in_hand'));
		}
		if($request->has('updated_by')){

			$query->where('users.name','like','%'.$request->get('updated_by').'%');
		}	

		$stocks = $query->get();

		/*echo '<pre>';
		print_r($stocks);
		echo '</pre>';
		exit;*/

		$iTotalRecords = count($stocks);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$stock = $stocks[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $stock->basic_qty,
		  $stock->name,
		  $stock->created_at,
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


	public function postExcel(Request $request){

		if($request->has('start_date')){
			$s_date = $request->get('start_date');
		}else{
			$s_date = '';	
		}
		

		if($request->has('end_date')){
			$e_date = $request->get('end_date');
		}else{
			$e_date = '';
		}

		$start_date = $s_date.' 00:00:00';
		if($e_date ==''){
			$end_date = $s_date.' 23:59:59';
		}else{
			$end_date = $e_date.' 23:59:59';
		}

		//echo $start_date.' '.$end_date ; exit;
		
		$stockArray = array();

		$stockArray = DB::select("SELECT p.product_name,pa.attribute_name,pap.price,pap.sale_price, pa.uom, c.category_name, c.id as category_id, pd.product_id,pd.purchase_qty,pd.purchase_price,od.actual_mrp,sum(od.qty) as sold_qty,sum(od.product_total) as sold_total  FROM procurement_details pd
JOIN products p on p.id = pd.product_id
join categories c on c.id= p.category_id
join product_attributes pa on pa.id = pd.attribute_id
join product_attribute_prices pap on pap.product_id = pd.product_id and pap.attribute_id = pd.attribute_id
left join order_details od on od.product_id = pd.product_id and od.attribute_id = pd.attribute_id 
where pd.created_at BETWEEN :proc_start_date and :proc_end_date
and  od.created_at BETWEEN :ord_start_date and :ord_end_date
GROUP by od.product_id,od.attribute_id",['proc_start_date' => $start_date,'proc_end_date' => $end_date,'ord_start_date' => $start_date,'ord_end_date' => $end_date]);

		//dd($stockArray);

		$excelOperation = Excel::create('StockSummary', function($excel) use($stockArray,$start_date) {

			$excel->setTitle('StockSummary');
	        $excel->setCreator('Agro7')->setCompany('Agro7 Wholesale');
	        $excel->setDescription('Stock Summary file');

	         $excel->sheet("Sheet", function($sheet) use($stockArray,$start_date) {

	         	$sheet->setOrientation('portrait');
		    	// Set top, right, bottom, left
				$sheet->setPageMargin(array(
				   0.354, 0.196, 0.157, 0.433
				));
				// Set width for multiple cells
				$sheet->setWidth(array(
				    'A'     =>  10,
				    'B'     =>  15.29,
				    'C'     =>  31.29,
				    'D'     =>  10.43,
				    'E'     =>  8.71,
				    'E'     =>  8.71,
				    'G'     =>  11.57,
				    'H'     =>  10,
				    'I'     =>  10,
				    'J'     =>  10,
				    'K'     =>  10
				));

				$sheet->mergeCells('A1:K1');
				$sheet->setCellValue('A1', 'Transven Lifestyle Management Private Limited');
				$sheet->cells('A1:K1', function($cells) {

	   			 // manipulate the range of cells
		    		// Set font size
					$cells->setFontSize(16);

					// Set font weight to bold
					$cells->setFontWeight('bold');
					$cells->setAlignment('center');

				});

				$sheet->mergeCells('A2:K2');
				$sheet->setCellValue('A2', 'Stock Summary');
				$sheet->cells('A2:K2', function($cells) {

	   			 // manipulate the range of cells
		    		// Set font size
					$cells->setFontSize(16);

					// Set font weight to bold
					$cells->setFontWeight('bold');
					$cells->setAlignment('center');

				});

				$sheet->mergeCells('A3:K3');
				$sheet->setCellValue('A3', $start_date);
				$sheet->cells('A3:K3', function($cells) {

	   			 // manipulate the range of cells
		    		// Set font size
					$cells->setFontSize(16);
					$cells->setAlignment('center');

				});


				$sheet->mergeCells('C5:E5');
				$sheet->mergeCells('F5:H5');

				$sheet->mergeCells('A5:A6');
				$sheet->mergeCells('B5:B6');
				$sheet->mergeCells('I5:I6');
				$sheet->mergeCells('J5:J6');
				$sheet->mergeCells('K5:K6');

				$sheet->cells('A5:K5', function($cells) {

		    		$cells->setFontWeight('bold');
					$cells->setFontSize(11);
					$cells->setAlignment('center');
					$cells->setValignment('center');

				});
				$sheet->row(5, array(
				     'Paticulars', 'Unit','Purchases','','','Outwards','','','Profit/Loss','%Amount','%Quantity'
				));

				$sheet->row(6, array(
				     '', '','Quantity','Rate','Value','Quantity','Rate','Value','','',''
				));

				$sheet->setBorder('A5:K6', 'thin');

				### This is for calculating Total Array ###
				$category_id = null;
				$totalCateArray = array();
				$totalCateValue = 0;
				$totalQtyValue = 0;
				foreach($stockArray as $s){
					if($category_id != $s->category_id){

						$category_id = $s->category_id;
						$totalCateValue = 0;
						$totalQtyValue = 0;
					}

					if($category_id == $s->category_id){

						$totalCateValue +=  $s->sold_total;
						$totalQtyValue +=  $s->sold_qty;
						$totalCateArray["$category_id"] = array("total" => $totalCateValue,"qty" =>$totalQtyValue);
					}
				}
				### This is for calculating Total Array ###

				/*echo '<pre>';
				print_r($totalCateArray );
				echo '</pre>';
				exit;
				*/

				$start=7;
				$category_id = null;
				$pur_unit_price_total = 0;
				$pur_total_price_total =0;
				$sell_unit_price_total = 0;
				$sell_total_price_total =0;
				$profit_loss_total =0;
				$amoutPer_total = 0;
				$qtyPer_total = 0;
				$grand_profit_loss_total =0;


		    	for($k=0; $k<count($stockArray); $k++){
		    		$stock = $stockArray[$k];

		    		### This is to be Add category title start ###	
		    		if($category_id != $stock->category_id){

		    			$sheet->cells("A$start:K$start", function($cells) {

				    		$cells->setFontWeight('bold');
							$cells->setFontSize(11);
							$cells->setAlignment('center');

							$pur_unit_price_total = 0;
							$pur_total_price_total =0;
							$sell_unit_price_total = 0;
							$sell_total_price_total =0;
							$profit_loss_total =0;
							$amoutPer_total = 0;
							$qtyPer_total = 0;

						});
						$sheet->mergeCells("A$start:K$start");

		    			$sheet->row($start,array($stock->category_name));
		    			$start++;
		    		}
		    		### This is to be Add category title Ends ###	

		    		$profitLoss = ($stock->actual_mrp - $stock->price)* $stock->purchase_qty;
		    		$amoutPer = round(($stock->sold_total /$totalCateArray[$stock->category_id]['total']) * 100 );
		    		$qtyPer = round(($stock->sold_qty /$totalCateArray[$stock->category_id]['qty']) * 100 );

		    		$pur_unit_price_total += $stock->price;
					$pur_total_price_total += $stock->purchase_qty * $stock->price;
					$sell_unit_price_total += $stock->actual_mrp;
					$sell_total_price_total += $stock->sold_total;
					$profit_loss_total += $profitLoss;
					$grand_profit_loss_total += $profitLoss;
					$amoutPer_total += $amoutPer;
					$qtyPer_total = $qtyPer;

		    		$category_id = $stock->category_id;
		    	
		    		$sheet->row($start,array($stock->product_name, $stock->uom, $stock->purchase_qty, $stock->price,  $stock->purchase_qty * $stock->price, $stock->sold_qty, $stock->actual_mrp , $stock->sold_total,$profitLoss,$amoutPer,$qtyPer ));
		    		$start++;

		    		### This is to be display total for paticular category start ###	
		    		if(!isset($stockArray[$k+1]->category_id) || $category_id != $stockArray[$k+1]->category_id){

		    				$sheet->row($start,array('','','',$pur_unit_price_total,$pur_total_price_total,'',$sell_unit_price_total,$sell_total_price_total,$profit_loss_total,$amoutPer_total,$qtyPer_total));

		    				$sheet->cells("A$start:K$start", function($cells) {
					    		$cells->setFontWeight('bold');	
							});

		    				$start++;

		    				$sheet->row($start,array('','','','','','','',''));
		    				$start++;
		    		}
		    		### This is to be display total for paticular category end ###
		    	}

		    	$sheet->rows(array(
		    		array(''),
		    		array(''),
		    		array('Grand Total','','','','','','','',$grand_profit_loss_total)
		    		));

		    	$totalRow = $start+2;
		    	
				$sheet->cells("A$totalRow:K$totalRow", function($cells) {

				    		$cells->setFontWeight('bold');
							

				});

				$sheet->setBorder("A7:K$totalRow", 'thin');
		    	


	        });

		});

		$excelOperation->export('xls');	

	}



}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel; // excel export purpose
use App\Order;
use App\OrderDetail;
use App\categories;
use DB;
class ExportProcurement extends Controller
{
    //
     public $menu = 'Product';
	public function index()
	{
	   $categories = DB::table('categories')	
                    ->where('status','1')
                    ->get();
      //  dd($categories);
		return view('procurement.exportprocurement',compact('menu','categories'));
	}

	public function export_procurement(Request $request)
	{
		 $date = $request->get('procurementdate');
     $category_id = $request->get('categories'); 
     $date  = date("Y-m-d", strtotime($request->get('procurementdate')));        
     if($category_id != 'ALL'){
		
     $order_details = DB::table('order_details as O')
   						->whereDate('O.created_at', '=', $date)
   						->join('products as P','P.id','=','O.product_id')
   						->join ('categories as C','C.id','=','P.category_id')
              ->where('C.id','=', $category_id)
   						->selectRaw('P.product_name as productName,actual_attribute_name as attribute,actual_uom as uom, sum(qty) as totalQty,C.category_name,O.created_at,C.id as category_id')
   						->groupBy('O.attribute_id')
              ->orderBy('C.id')
			  ->orderBy('P.order_by','DESC')
			  ->orderBy('P.product_name')
   						->get();
            }else
            {
               $order_details = DB::table('order_details as O')
              ->whereDate('O.created_at', '=', $date)
              ->join('products as P','P.id','=','O.product_id')
              ->join ('categories as C','C.id','=','P.category_id')
              ->selectRaw('P.product_name as productName,actual_attribute_name as attribute,actual_uom as uom, sum(qty) as totalQty,C.category_name,O.created_at,C.id as category_id')
              ->groupBy('O.attribute_id')
              ->orderBy('C.id')
			  ->orderBy('P.order_by','DESC')
			  ->orderBy('P.product_name')
              ->get();
            }

           // dd($order_details);
   $this->getExcel($order_details); 

		  return redirect()->route('exportprocurement')->with('status', 'Succesfully download...!');
	}


public function getExcel($orderdetailArray){

    
       
        $excelOperation = Excel::create('procurementdetails', function($excel) use($orderdetailArray) {

            $excel->setTitle(' Procurement Details');
            $excel->setCreator('Agro7')->setCompany('Agro7 Wholesale');
           // $excel->setDescription('Stock Summary file');

             $excel->sheet("Sheet", function($sheet) use($orderdetailArray) {

                 $sheet->setOrientation('portrait');
                // Set top, right, bottom, left
                $sheet->setPageMargin(array(
                   0.354, 0.196, 0.157, 0.433
                ));
                // Set width for multiple cells
                /*$sheet->setWidth(array(
                    'A'     =>  10,
                    'B'     =>  15.29,
                    'C'     =>  31.29,
                    'D'     =>  10.43,
                    'E'     =>  8.71,
                    'G'     =>  11.57,
                    'H'     =>  16.29
                ));*/

                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'Transven Lifestyle Management Private Limited');
                $sheet->setBorder('A1:G1', 'thin');
                $sheet->cells('A1:G1', function($cells) {

                    // manipulate the range of cells
                    // Set font size
                    $cells->setFontSize(16);

                    // Set font weight to bold
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->mergeCells('A2:G2');
                $sheet->setCellValue('A2', ' ');
                $sheet->cells('A2:G2', function($cells) {

                    // manipulate the range of cells
                    // Set font size
                    $cells->setFontSize(16);

                    // Set font weight to bold
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');

                });

                $sheet->mergeCells('A3:G3');
                $sheet->setCellValue('A3', 'Procurement List');
                $sheet->setBorder('A1:G3', 'thin');
                $sheet->cells('A3:G3', function($cells) {

                    // manipulate the range of cells
                    // Set font size
                    $cells->setFontSize(16);
                    $cells->setAlignment('center');

                });


                $sheet->row(7, array(
                     'Sr. No.', 'Person','Description','Unit','Qty.','Rate/Unit','Value'
                ));
                $sheet->setBorder("A7:G7", 'thin');
                 $sheet->setBorder("A8:G8", 'thin');
                $j=8;
                $i=1;
                
                $category_id = 0;
                $k = 8;
                foreach ($orderdetailArray as $orderdetail) {

                   if($category_id != $orderdetail->category_id)
                   {
                        $sheet->mergeCells("A$k:G$k");
                        $sheet->setCellValue("A$k", $orderdetail->category_name);
                        
                         $sheet->cells("A$k:G$k", function($cells) {

                              // manipulate the range of cells
                              // Set font size
                              $cells->setFontSize(12);

                              // Set font weight to bold
                              $cells->setFontWeight('bold');
                              $cells->setAlignment('center');

                        });
                        $k++;
                   }

                  $sheet->row($k++, array(
                     $i++, ' ',$orderdetail->productName,$orderdetail->uom,$orderdetail->totalQty,' ',' '
                 ));
                  $sheet->setBorder("A$k:G$k", 'thin');
                  $category_id = $orderdetail->category_id;
                 //  $k++;
                    
                }

                $k = $k + 2 ;
                $sheet->mergeCells("A$k:B$k");
                $sheet->setCellValue("A$k", 'Prepared by:');
                
                $sheet->mergeCells("D$k:E$k");
                $sheet->setCellValue("D$k", 'Checked by:');

                $k= $k +3;
                $sheet->mergeCells("A$k:B$k");
                $sheet->setCellValue("A$k", 'Name & Designation');

                $sheet->mergeCells("D$k:E$k");
                $sheet->setCellValue("D$k", 'Name & Designation');

                $k = $k +1;
                $sheet->mergeCells("A$k:B$k");
                $sheet->setCellValue("A$k", 'Signature');
                $sheet->mergeCells("D$k:E$k");
                $sheet->setCellValue("D$k", 'Signature');

                $k = $k +3;
                $sheet->setCellValue("C$k", 'Reviewed & Authorised by');
                $k = $k+3;
                $sheet->setCellValue("C$k", 'Name & Designation');
                $k= $k +1;
                $sheet->setCellValue("C$k", 'Signature');

                //exit;
            });

        });
       
       $excelOperation->export('xls');    

    }

}

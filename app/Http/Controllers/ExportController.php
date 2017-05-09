<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
Use DB;

class ExportController extends Controller {

    public $menu = 'ExportImport';
    public $subMenu = 'CustomExport';

    public function getStocksummary() {
        $menu = $this->menu;
        $subMenu = $this->subMenu;
        return view('export.stockSummary', compact('menu', 'subMenu'));
    }

    public function getOrderscustomer() {
       
        $menu = $this->menu;
        $subMenu = $this->subMenu;
        return view('export.ordersCustomer', compact('menu', 'subMenu'));
    }

    /*
     * this function will be laod the view for export customer list and order details as 
     * per the locality selected.
     * added by vijay
     */

    public function getOrdercustomerlocality() {
         $locality = DB::table('zones')
                          ->where('status','=','1')
                          ->get();
        
        $menu = $this->menu;
        $subMenu = $this->subMenu;
        return view('export.ordercustomerlocality', compact('menu', 'subMenu','locality'));
    }

	
	### Common Export function Start ###	
    public function getCommonexport()
    {
        $menu = $this->menu;
        $subMenu = $this->subMenu;
        $tables = DB::select('SHOW TABLES');

         $db_name = env('DB_DATABASE');
         $keyname = "Tables_in_$db_name";


        return view('export.commonExport',compact('tables','keyname' ,'menu','subMenu'));
    }

    public function postCommonexportcolumn($tableName){
             $columns = DB::select("SHOW COLUMNS from $tableName");

        print_r(json_encode($columns) );

    }

    public function postCommonexportexcel(Request $request){

       // dd($request);
       


        if($request->has('table_columns') && $request->has('table_columns')){

             $tableName =  $request->get('table_name');
            $columnName =  $request->get('table_columns');

            if(is_array($columnName)){

                
            }else{
               $columnName = ["$columnName"];
            }

            $tables = DB::table("$tableName")
                        ->select( $columnName);

            if($request->has('skip')){
                $tables->skip( $request->get('skip') );    
            }

            if($request->has('take')){
                $tables->take( $request->get('take') );    
            }
            
            $tables = $tables->get();
                   

            foreach($tables as $object)
            {
                $table[] = (array)$object;
      
            }


            $excelOperation = Excel::create("Table_$tableName", function($excel) use($table) {

                $excel->sheet("Sheet", function($sheet) use($table) {

                    $sheet->fromArray($table);

                });

            });

            $excelOperation->export('xls');
        }else{

            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
        }

    }
	### Common Export function Ends ###
	
	
	
	### Customer Comment Export function Start ###
	public function getCustomercomment()
    {
        $menu = $this->menu;
        $subMenu = $this->subMenu;
        $customers = \App\Customer::get(['id','first_name','last_name']);

        return view('export.customerComment',compact('customers','menu','subMenu'));
    }

    public function postCustomercommentexcel(Request $request){

         $query = DB::table("customers")
                        ->select('comment','first_name','last_name');

        if($request->has('customer_id')){
            $customer_id = $request->get('customer_id');
            $query->whereIn('id',$customer_id );
        }

       $customers =  $query->get();


        $excelOperation = Excel::create('Customer Comment', function($excel) use($customers) {

             $excel->sheet("Sheet", function($sheet) use($customers) {

                $k = 2;
                foreach ($customers as $customer) {
                                    
                    $kn = $k+1;
                     $rangeMergeRestaurant = "E$k:N$k";
                     $rangeMergeComment = "D$kn:O$kn";

                     $rangeStyleRestaurant = "E$k:N$k";
                     $rangeStyleComment = "D$kn:O$kn";

                    $sheet->mergeCells($rangeMergeRestaurant);
                    $sheet->mergeCells($rangeMergeComment);

                    $sheet->cells($rangeStyleRestaurant, function($cells) {
                        $cells->setFontSize(26);
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });

                    $sheet->cells($rangeStyleComment, function($cells) {
                        $cells->setFontSize(24);
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });

                     $sheet->row($k, array(
                               '','','','', $customer->first_name.' '.$customer->last_name,
                            ));

                     $sheet->row($kn, array(
                               '','','', $customer->comment,
                            ));

                     $sheet->row($k+2, array(
                               '','',''
                            ));

                    $k = $k+3;
                }


             });

        });

        $excelOperation->export('xls');

    }
	### Customer Comment Export function Ends ###


    ####################################################
    ####### Summary Order Receipt function start #######
    ####################################################

    public function getOrderreceipt()
    {
        $menu = $this->menu;
        $subMenu = $this->subMenu;
        //$customers = \App\Customer::get(['id','first_name','last_name']);

        $customers =  \App\Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
            $customerOption[""] = 'Choose Customer';
            foreach ($customers as $customer) {
                $customerOption["$customer->id"] =  $customer->first_name.' '.$customer->last_name ;
            }

        return view('export.statementOrderReceipt',compact('customerOption','menu','subMenu'));
    }

    public function postOrderreceiptexcel(Request $request){

      $date_from_to ; 
      ### Payment Receipt query Start ###
      $queryReceipt = DB::table("payment_receipt")
                      ->select('paid_at as date', DB::raw(' "" as order_id, "" as order_total '), 'id as receipt_id','amount as paid_amount');

      if($request->has('customer_id')){
          $queryReceipt->where('customer_id','=', $request->get('customer_id') );
      }

      if($request->has('address_id')){
          $queryReceipt->where('address_id','=', $request->get('address_id') );
      }

      if ($request->has('date_from') && !$request->has('date_to')) {
          $queryReceipt->where('paid_at','=', $request->get('date_from'));
          $date_from_to = $request->get('date_from') ;

      } elseif ($request->has('date_from') && $request->has('date_to')) {
          $queryReceipt->whereBetween('paid_at', [$request->get('date_from'), $request->get('date_to')]);

           $date_from_to = $request->get('date_from'). ' to '. $request->get('date_to') ;
      }

     // $paymentReceipts =  $queryReceipt->get();
      ### Payment Receipt query Ends ###


      ##### Order query Start #####
      $query = DB::table("orders")
                    ->select(DB::raw('date(created_at) as date') ,'id as order_id','order_total',DB::raw(' "" as receipt_id, "" as paid_amount '));

      if($request->has('customer_id')){
          $query->where('customer_id','=', $request->get('customer_id') );
      }

      if($request->has('address_id')){
          $query->where('address_id','=', $request->get('address_id') );
      }

      if ($request->has('date_from') && !$request->has('date_to')) {
         $query->whereBetween('created_at', [$request->get('date_from') . ' 00:00:00', $request->get('date_from') . ' 23:59:59']);

      } elseif ($request->has('date_from') && $request->has('date_to')) {
         $query->whereBetween('orders.created_at', [$request->get('date_from') . ' 00:00:00', $request->get('date_to') . ' 23:59:59']);
      }

      //Doing union of both query
      $query->union($queryReceipt);
      $query->orderBy('date');
     // $query->where('order_stage','=', 'INVOICE_CONFIRMED' );

      $summaryReceipt =  $query->get();

      $customers =  \App\Customer::where('id','=',$request->get('customer_id'))
                      ->get(['id','first_name','last_name'])->first();

      $address =  \App\Address::find($request->get('address_id'));

      $address = $address->getFullAddress();

      //dd($test_address);

      $excelOperation = Excel::create('Receipt Summary', function($excel) use($summaryReceipt, $customers, $date_from_to, $address) {

          $excel->sheet("Sheet", function($sheet) use($summaryReceipt, $customers, $date_from_to, $address) {

            $sheet->setWidth(array(
                'A' => 11,
                'B' => 13,
                'C' => 15,
                'D' => 11,
                'E' => 12,
                'F' => 11,
                'G' => 12 
            ));

            $sheet->mergeCells("B2:G2");
            $sheet->cells("B2:G2", function($cells) {
                 // $cells->setFontSize(26);
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
            });
            $sheet->row(2, array(
                  '','Transven Lifestyle Management Private Limited (Agro7)'
                ));


            $sheet->mergeCells("B3:G3");
            $sheet->cells("B3:G3", function($cells) {
                  $cells->setAlignment('center');
            });
            $sheet->row(3, array(
                  '','Warehouse: Andheri, Prabhadevi, Thane & Navi Mumbai'
                ));


            $sheet->mergeCells("B4:G4");
            $sheet->cells("B4:G4", function($cells) {
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
            });
            $sheet->row(4, array(
                  '','Sales and Outstanding Statement of '.$customers->first_name.' '.$customers->last_name
                ));


            $sheet->mergeCells("B5:G5");
            $sheet->cells("B5:G5", function($cells) {
                 $cells->setFontSize(9);
                 // $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
            });
             $sheet->row(5, array(
                  '',$address
            ));

            $sheet->mergeCells("B6:G6");
            $sheet->cells("B6:G6", function($cells) {
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
            });
             $sheet->row(6, array(
                  '','Period '.$date_from_to
                ));


            $sheet->cells("B8:G8", function($cells) {
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
            });
            $sheet->setBorder("B8:G8", 'thin');
            $sheet->row(8, array(
                '','Date','Invoice Number','Amount','Receipt No','Payment','Cumulative'
              ));

             $k =9 ;
             $grant_total = 0;
             $paid_total = 0;
            foreach ($summaryReceipt as $receipt) {

              $rangeBorder = "B$k:G$k";
              $sheet->setBorder($rangeBorder, 'thin');

                $grant_total +=  $receipt->order_total ;
                $paid_total +=  $receipt->paid_amount ;
              $sheet->row($k, array(
                '', $receipt->date, $receipt->order_id, $receipt->order_total, $receipt->receipt_id, $receipt->paid_amount,$grant_total
              ));

              $k++;
            }

            $sheet->setBorder("B$k:G$k", 'thin');
            $sheet->row($k, array(
              '',''
            ));

            $k++;
            $sheet->setBorder("B$k:G$k", 'thin');
            $sheet->cells("B$k:G$k", function($cells) {
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
            });
            $sheet->row($k, array(
              '','','Total',$grant_total,'Total Paid',$paid_total,''
            ));


            $k++;
            $sheet->cells("B$k:G$k", function($cells) {
              $cells->setFontWeight('bold');
              $cells->setAlignment('center');
            });
            $sheet->row($k, array(
              '','','Outstanding Amount','',$grant_total - $paid_total
            ));

          });
      });

      $excelOperation->export('xls');
      

      ##### Order query End #####
     //dd($orders);
      
    }

    ####################################################
    ####### Summary Order Receipt function end #######
    ####################################################

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\Order;
use App\OrderDetail;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use \stdClass;

class OrderGeneralController extends Controller {

    public function postInvoiceconfirm(Request $request, $id) {

        $orderUpdate = [

            'order_stage' => $request->get('order_stage'),
        ];

        $response = Order::find($id)->update($orderUpdate);
        if ($response) {
            echo 'SUCCESS';
        }
    }

    public function getBulkinvoice(Request $request) {

        $query = DB::table('orders')
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->select('orders.id', 'orders.order_total', 'orders.created_at', 'customers.first_name', 'customers.last_name', 'orders.order_stage');


        if ($request->has('order_id')) {

            $query->where('orders.id', '=', $request->get('order_id'));
        }
        if ($request->has('order_total')) {

            $query->where('orders.order_total', '=', $request->get('order_total'));
        }
        if ($request->has('customer_id')) {

            $query->where('customers.id', '=', $request->get('customer_id'));
        }

        if ($request->has('created_from') && !$request->has('created_to')) {

            $query->whereBetween('orders.created_at', [$request->get('created_from') . ' 00:00:00', $request->get('created_from') . ' 23:59:59']);
        } elseif ($request->has('created_from') && $request->has('created_to')) {

            $query->whereBetween('orders.created_at', [$request->get('created_from') . ' 00:00:00', $request->get('created_to') . ' 23:59:59']);
        }

        if ($request->has('order_stage')) {

            $query->where('orders.order_stage', '=', $request->get('order_stage'));
        }

        $query->whereNull('orders.deleted_at');  
        $query->orderBy('orders.id', 'desc');

        $orders = $query->get();

        //dd($orders);

        $this->getExcel($orders);
    }

    public function postOrder(Request $request) {


        $query = DB::table('orders as o')
                ->join('customers', 'o.customer_id', '=', 'customers.id')
                ->select('o.id', 'o.order_total', 'o.created_at', 'customers.first_name', 'customers.last_name', 'o.order_stage', DB::raw('(select count(odc.id) as issue from order_detail_comments odc join order_details od on od.id = odc.order_detail_id where od.order_id = o.id and odc.comment_status in("ISSUE","REQUEST") group by o.id )as issue')
        );

        if ($request->has('order_id')) {

            $query->where('o.id', '=', $request->get('order_id'));
        }
        if ($request->has('order_total')) {

            $query->where('o.order_total', '=', $request->get('order_total'));
        }
        if ($request->has('customer_id')) {

            $query->where('customers.id', '=', $request->get('customer_id'));
        }

        if ($request->has('created_from') && !$request->has('created_to')) {

            $query->whereBetween('o.created_at', [$request->get('created_from') . ' 00:00:00', $request->get('created_from') . ' 23:59:59']);
        } elseif ($request->has('created_from') && $request->has('created_to')) {

            $query->whereBetween('o.created_at', [$request->get('created_from') . ' 00:00:00', $request->get('created_to') . ' 23:59:59']);
        }

        if ($request->has('order_stage')) {

            $query->where('o.order_stage', '=', $request->get('order_stage'));
        }

        $query->whereNull('o.deleted_at');  
        $query->orderBy('o.id', 'desc');

        $orders = $query->get();
        /* echo '<pre>';
          print_r($stocks);
          echo '</pre>';
          exit; */
        //dd($stocks);
        //print_r( $addres->city );
        //dd( $stocks[0]->product->product_name);
        $iTotalRecords = count($orders);
        $iDisplayLength = intval($request->get('length'));
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($request->get('start'));
        $sEcho = intval($request->get('draw'));

        $records = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $order = $orders[$i];
            //$status = $status_list[rand(0, 2)];
            $id = ($i + 1);

            if ($order->issue > 0) {
                $issue_notif = '<span title="Order With issue or change Request" class="badge badge-danger pull-left">' . $order->issue . ' </span>';
            } else {
                $issue_notif = '';
            }

            $lable_class = ($order->order_stage == 'UPDATED') ? 'label-danger' : 'label-default';

            $records["data"][] = array(
                '<input type="checkbox" name="id[]" value="' . $id . '">',
                $order->id,
                $order->order_total,
                $order->first_name . ' ' . $order->last_name,
                '<span class="invoice-confirm label label-sm ' . $lable_class . ' ">' .
                $order->order_stage . '</span>',
                $order->created_at,
                '<a href="' . route('order.show', $order->id) . '" class="btn btn-xs default">View</a>' .
                '<a href="' . route('order.edit', $order->id) . '" class="btn btn-xs">' .
                $issue_notif .
                '&nbsp;&nbsp;Edit
           </a> 
		   <form style="float:right" action="' . route('order.destroy', $order->id) . '" method="post" >
		   <input type="hidden" name="_method" value="DELETE" />
		   <input type="hidden" name="_token" value="' . csrf_token() . '" />
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

    public function convert_number_to_words($number) {

        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            10000 => 'ten thousand',
            100000 => 'lakh',
            1000000 => 'ten lakh',
            10000000 => 'crore',
            100000000 => 'ten crore',
            1000000000 => 'hundred crore',
            10000000000 => 'thousand crore',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public function index() {

        echo 'PAGE Not Found';
    }

    // This function is used to dispaly will move in CustomerGeneral Controllers
    public function postAddress($id) {

        $address = Customer::find($id)->address;
        //print_r( $addres->city );
        //dd($address);
        foreach ($address as $addres) {

            $city_name = isset($addres->city->city_name) ? $addres->city->city_name : '';
            $locality_name = isset($addres->locality->locality_name) ? $addres->locality->locality_name : '';
            $state_name = isset($addres->state->state_name) ? $addres->state->state_name : '';

            $addressOption["$addres->id"] = $addres->address_line1 . ' ' . $addres->address_line2 . ' ' . $addres->street . ' ' . $addres->pin_code . ' ' . $city_name . ' ' . $locality_name . ' ' . $state_name;
        }
        return view('pages.orders.addressSelect', compact('addressOption'));
    }

    public function getExcel($orderId, $method = '') {

        //$users = User::select('id', 'name', 'email', 'created_at')->get();
        $bulkInvoiceArray = [];
        $bulkOtherDetailArray = [];
        $bulkOrder = [];
        $bulkCustomer = [];
        $bulkCustAddress = [];
        $bulkContactDetail = [];

        if (!is_array($orderId)) {

            $orderArray[] = (object) array('id' => $orderId);
        } else {

            $orderArray = $orderId;
        }

        //dd($orderArray);
        foreach ($orderArray as $order) {

            $orders = Order::find($order->id);
            $customer = $orders->customer;
            $contactDetail = $orders->customer->contactDetails()->where('default', '=', 'YES')->first();
            $custAddress = $orders->address;

            //dd($contactDetails);
            $orderDetails = OrderDetail::Where('order_id', '=', $order->id)->get();

            $invoiceArray = [];

            $invoiceArray[] = ['SrNo', 'Description', '', '', 'Unit', 'Quantity', 'Rate/Unit', 'Amount'];

            $i = 0;
            foreach ($orderDetails as $orderDetial) {

                //$orderDetial->product
                $invoiceArray[] = [ ++$i, $orderDetial->product_name, '', '', $orderDetial->actual_uom, $orderDetial->qty, $orderDetial->actual_mrp, $orderDetial->product_total];
            }

            $invoiceArray[] = ['', '', '', '', 'Sub-total', '', '', $orders->sub_total];
            $invoiceArray[] = ['', '', '', '', 'Delivery and Handling Charges', '', '', $orders->delivery_charge];
            $invoiceArray[] = ['', '', '', '', 'Grand Total (Rounded off)', '', '', round($orders->order_total)];


            $otherDetailArray = array('order_total' => $orders->order_total, 'invoice_no' => $orders->id, 'invoice_date' => $orders->created_at);

            $bulkInvoiceArray[] = $invoiceArray;
            $bulkOtherDetailArray[] = $otherDetailArray;
            $bulkOrder[] = $orders;
            $bulkCustomer[] = $customer;
            $bulkCustAddress[] = $custAddress;
            $bulkContactDetail[] = $contactDetail;
        }


        $excelOperation = Excel::create('Invoice', function($excel) use($bulkInvoiceArray, $bulkOtherDetailArray, $bulkCustomer, $bulkCustAddress, $bulkContactDetail, $bulkOrder) {



                    $excel->setTitle('Invoice');
                    $excel->setCreator('Agro7')->setCompany('Agro7 Wholesale');
                    $excel->setDescription('Invoice file');

                    // Build the spreadsheet, passing in the payments array
                    //dd($bulkOtherDetailArray);
                    for ($i = 0; $i < count($bulkInvoiceArray); $i++) {

                        $invoiceArray = $bulkInvoiceArray[$i];
                        $otherDetailArray = $bulkOtherDetailArray[$i];
                        $customer = $bulkCustomer[$i];
                        $custAddress = $bulkCustAddress[$i];
                        $contactDetail = $bulkContactDetail[$i];
                        $orders = $bulkOrder[$i];

                        $excel->sheet("Sheet $i", function($sheet) use($invoiceArray, $otherDetailArray, $customer, $custAddress, $contactDetail, $orders) {

                            $orderTotalInWords = $this->convert_number_to_words(round($orders->order_total));
                            //### Sheet Setting  ### Start
                            //Set page orientation landscape or portrait
                            $sheet->setOrientation('portrait');
                            // Set top, right, bottom, left
                            $sheet->setPageMargin(array(
                                0.354, 0.196, 0.157, 0.433
                            ));


                            // Set width for multiple cells
                            /* $sheet->setWidth(array(
                              'A'     =>  10,
                              'B'     =>  15.29,
                              'C'     =>  31.29,
                              'D'     =>  10.43,
                              'E'     =>  8.71,
                              'G'     =>  11.57,
                              'H'     =>  16.29
                              ));
                             */
                            $sheet->setWidth(array(
                                'A' => 11,
                                'B' => 16,
                                'C' => 29.29,
                                'D' => 10.43,
                                'E' => 8.71,
                                'G' => 11.57,
                                'H' => 16.29
                            ));
                            // Set height for multiple rows
                            /* $sheet->setHeight(array(
                              1     =>  50,
                              2     =>  25
                              )); */
                            //### Sheet Setting  ### End
                            $sheet->mergeCells('A1:H1');

                            $sheet->setCellValue('A1', 'Agro7');
                            $sheet->cells('A1:H1', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(16);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });

                            $sheet->mergeCells('A2:H2');

                            $sheet->setCellValue('A2', 'Sale Invoice');
                            $sheet->cells('A2:H2', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(16);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });


                            $sheet->cells('A5:H5', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(11);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $sheet->mergeCells('A5:B5');
                            //$sheet->mergeCells('A6:B6');
                            $sheet->mergeCells('E6:H6');
                            $sheet->cells('E6:H6', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(11);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $sheet->mergeCells('E7:H7');
                            $sheet->cells('E7:H7', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(11);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $sheet->mergeCells('E8:H8');
                            $sheet->cells('E8:H8', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(11);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $sheet->mergeCells('E9:H9');
                            $sheet->cells('E9:H9', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(11);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });


                            $sheet->row(5, array(
                                'Seller Name & Address:', '', '', '', 'Buyer/Consignee Name & Address:', ''
                            ));

                            // Manipulate 2nd row
                            $sheet->row(6, array(
                                'Transven lifestyle Management Private Limited', '', '', '', $customer->first_name . ' ' . $customer->last_name
                            ));

                            if (isset($custAddress)) {
                                $addresss_first = isset($custAddress->address_line1) ? $custAddress->address_line1 : '';
                                $addresss_first .='  ';
                            } else {
                                $addresss_first = '';
                            }


                            $sheet->row(7, array(
                                '', '', '', '', trim($addresss_first)
                            ));

                            if (isset($custAddress)) {

                                $addresss_second = isset($custAddress->address_line2) ? $custAddress->address_line2 : '';
                                $addresss_second .= ' ';
                                $addresss_second = isset($custAddress->street) ? $custAddress->street : '';
                                $addresss_second .= ' ';
                            } else {
                                $addresss_second = '';
                            }

                            if (isset($custAddress)) {


                                $addresss_third = isset($custAddress->locality->locality_name) ? $custAddress->locality->locality_name : '';
                                $addresss_third .= ' ';
                                $addresss_third .= isset($custAddress->city->city_name) ? $custAddress->city->city_name : '';
                                $addresss_third .= ' ';
                                $addresss_third .= isset($custAddress->state->state_name) ? $custAddress->state->state_name : '';
                                $addresss_third .= ' ';
                                $addresss_third .= isset($custAddress->pin_code) ? $custAddress->pin_code : '';
                                $addresss_third .= ' ';
                            } else {
                                $addresss_third = '';
                            }

                            if (trim($addresss_second) == '') {
                                $addresss_second = $addresss_third;
                                $addresss_third = '';
                            }

                            $sheet->row(8, array(
                                '', '', '', '', trim($addresss_second)
                            ));

                            $sheet->row(9, array(
                                '', '', '', '', trim($addresss_third)
                            ));

                            $contactDetailName = isset($contactDetail->first_name) ? $contactDetail->first_name : '';
                            $contactDetailName = isset($contactDetail->last_name) ? $contactDetail->last_name : '';

                            $sheet->row(10, array(
                                'Contact No', '+91-7710890777/ +91-7715806777', '', '', 'Contact Person:', '', $contactDetailName
                            ));


                            $sheet->cell('B11', function($cell) {

                                // manipulate the cell
                                // $cell->setFontColor('#ff0000');
                            });

                            //$contactDetailNo = isset($contactDetail->contact_no)?$contactDetail->contact_no:'';

                            $contactDetailNo = $customer->contact_no;
                            $sheet->row(11, array(
                                'PAN', 'AAECT9469R', '', '', 'Contact Details:', '', $contactDetailNo
                            ));

							$devliery_prefer_time = date("H:i",strtotime($customer->delivery_prefer_time));
							$sheet->row(12, array(
                                '','','','','Delivery Time', '', $devliery_prefer_time, ''
                            ));

                            $sheet->mergeCells('C14:D14');
                            $sheet->mergeCells('E14:F14');
                            $sheet->mergeCells('G14:H14');
                            $sheet->setBorder('A14:H14', 'thin');
                            $sheet->cells('A14:H14', function($cells) {

                                // manipulate the range of cells
                                // Set font size
                                $cells->setFontSize(11);

                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });
                            $sheet->row(14, array(
                                'Date', 'Invoice No.', 'Sales Person', '', '', '', 'Payment Terms'
                            ));

                            $invoice_date = explode(" ", $otherDetailArray['invoice_date']);
                            $time = strtotime($invoice_date[0]);
                            $newformat = date('Y/m', $time);
                            $invoiceNo = $newformat . '/WSO' . $otherDetailArray['invoice_no'];
                            $introduce_by = isset($orders->customer->introduceUser->name) ? $orders->customer->introduceUser->name : '';

                            $sheet->mergeCells('C15:D15');
                            $sheet->mergeCells('E15:F15');
                            $sheet->mergeCells('G15:H15');
                            $sheet->setBorder('A15:H15', 'thin');
                            $sheet->row(15, array(
                                $invoice_date[0], $invoiceNo, $introduce_by, '', '', '', 'Cash'
                            ));

                            $sheet->cells('A15:H15', function($cells) {
                                $cells->setAlignment('center');
                            });
                            //echo count($invoiceArray);
                            //echo '<br/>';
                            //$sheet->mergeCells('A1:F1');
                            $sheet->cells('A17:H17', function($cells) {

                                $cells->setFontSize(11);
                                $cells->setFontWeight('bold');
                                $cells->setBackground('#e5e2e2');
                                $cells->setAlignment('center');
                            });

                            $start = 17;
                            for ($k = $start; $k < count($invoiceArray) + $start; $k++) {


                                $rangeBorder = "A$k:H$k";

                                $rangeMerge = "B$k:D$k";

                                $rangeAlignment = "F$k:H$k";

                                $sheet->setBorder($rangeBorder, 'thin');
                                $sheet->mergeCells($rangeMerge);
                                $sheet->cells($rangeAlignment, function($cells) {
                                    $cells->setAlignment('right');
                                });
                                $sheet->cell("A$k", function($cell) {
                                    $cell->setAlignment('center');
                                });
                                $sheet->cell("E$k", function($cell) {
                                    $cell->setAlignment('center');
                                });

                                if ($k >= (count($invoiceArray) + $start - 3)) {
                                    $rangeSubMerge = "E$k:G$k";
                                    $sheet->mergeCells($rangeSubMerge);

                                    $sheet->cells($rangeSubMerge, function($cells) {

                                        $cells->setFontSize(11);
                                        // Set font weight to bold
                                        $cells->setFontWeight('bold');
                                    });
                                }
                            }



                            //$sheet->setBorder('A17:H17', 'thin');
                            $sheet->fromArray($invoiceArray, null, 'A17', false, false);


                            // Append row as very last
                            $sheet->rows(array(
                                array('', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('Amount in words', '', ucfirst($orderTotalInWords), '', 'For Transven lifestyle Management Private Limited'),
                                array('', '', '', '', ''),
                                array('Remarks', '', $orders->remark, '', ''),
                                array('', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('Bank Details', '', '', 'Delivery Acknowledgement', '', '', '', 'Delivery by:'),
                                array('Beneficiary Bank ', '', 'ICICI Bank', '', '', '', '', ''),
                                array('Beneficiary A/c No. ', '', '1022 050 05958', '', '', '', '', ''),
                                array('IFSC Code ', '', 'ICIC0001022', 'Signature', '', '', '', 'Signature'),
                                array('Branch Address', '', 'Chandivali Branch, Mumbai - 72', '', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('Please ask for receipts while making the payments.', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('This is a computer generated invoice. No Signature required.', '', '', '', ''),
                                array('', '', '', '', ''),
                                array('THANKS FOR YOUR VALUABLE BUSINESS!', '', '', '', ''),
                            ));



                            //#####  Formatting Footer Excel Start #####3
                            $k = $k + 2;
                            $sheet->mergeCells("A$k:B$k");
                            $sheet->cells("A$k:h$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $k = $k + 2;
                            $sheet->mergeCells("A$k:B$k");
                            $sheet->cells("A$k:h$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $k = $k + 4;
                            $sheet->cells("A$k:H$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $k = $k + 3;
                            $sheet->cells("D$k:H$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                            });

                            $k = $k + 4;
                            $sheet->mergeCells("A$k:H$k");
                            $sheet->cells("A$k:H$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });
                            $k = $k + 2;
                            $sheet->mergeCells("A$k:H$k");
                            $sheet->cells("A$k:H$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });
                            $k = $k + 2;
                            $sheet->mergeCells("A$k:H$k");
                            $sheet->cells("A$k:H$k", function($cells) {

                                $cells->setFontSize(11);
                                // Set font weight to bold
                                $cells->setFontWeight('bold');
                                $cells->setAlignment('center');
                            });

                            $acc_no = $start + 11;
                            $sheet->cell("C$acc_no", function($cell) {
                                $cell->setAlignment('left');
                            });
                            //###### Formatting Footer Excel Ends #######
                            //$sheet->setBorder("A1:H$k", 'thin');
                            // Append row as very last
                        });
                    }
                });

        if ($method == 'store') {

            return $excelOperation->store('xls', false, true);
        } else {

            $excelOperation->export('xls');
        }
    }

    /* added by vijay for export customer information as per datewise order */

    public function postExportcustomer(Request $request) {

        $date = date("Y-m-d", strtotime($request->get('orderdate')));
        $customer_info = DB::table('orders as O')
                ->whereDate('O.created_at', '=', $date)
                ->join('customers as C', 'O.customer_id', '=', 'C.id')
                ->join('address as A', 'A.customer_id', '=', 'C.id')
                ->join('locality as L', 'L.id', '=', 'A.locality_id')
                ->join('city', 'city.id', '=', 'L.city_id')
                ->selectRaw('C.first_name,C.last_name,C.delivery_prefer_time,O.id as orderid,O.comment,O.order_total,A.address_line1,A.address_line2,A.street,A.pin_code,L.locality_name,city.city_name')
				->whereNull('O.deleted_at')
                ->orderBy('C.delivery_prefer_time')
                ->get();
        // dd($customer_info);


        $excelOperation = Excel::create('custoemerdetails', function($excel) use($customer_info) {

                    $excel->setTitle('Customer Details as per order');
                    $excel->setCreator('Agro7')->setCompany('Agro7 Wholesale');
                    // $excel->setDescription('Stock Summary file');

                    $excel->sheet("Sheet", function($sheet) use($customer_info) {
                        $sheet->setOrientation('portrait');
                        // Set top, right, bottom, left
                        $sheet->setPageMargin(array(
                            0.354, 0.196, 0.157, 0.433
                        ));
                        $sheet->mergeCells('A1:N1');
                        $sheet->setCellValue('A1', 'Transven Lifestyle Management Private Limited');
                        $sheet->setBorder('A1:N1', 'thin');
                        $sheet->cells('A1:N1', function($cells) {

                            // manipulate the range of cells
                            // Set font size
                            $cells->setFontSize(16);

                            // Set font weight to bold
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                        });

                        $sheet->mergeCells('A2:N2');
                        $sheet->setCellValue('A2', ' ');
                        $sheet->cells('A2:N2', function($cells) {

                            // manipulate the range of cells
                            // Set font size
                            $cells->setFontSize(16);

                            // Set font weight to bold
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                        });
                        $sheet->mergeCells('A3:N3');
                        $sheet->setCellValue('A3', 'Customer List');
                        $sheet->setBorder('A1:N3', 'thin');
                        $sheet->cells('A3:N3', function($cells) {

                            // manipulate the range of cells
                            // Set font size
                            $cells->setFontSize(16);
                            $cells->setAlignment('center');
                        });
                        //  C.first_name,C.last_name,C.delivery_prefer_time,O.id as orderid,O.comment,A.address_line1,A.address_line2,A.street,A.pin_code,L.locality_name,city.city_name
                        $sheet->row(7, array(
                            'Sr. No.', 'Order id', 'Order Total', 'Restorent Name', 'delivery_prefer_time', 'order comment', 'Address line1', 'Address line2', 'Street', 'Locality', 'City Name', 'Pin code'
                        ));
                        $sheet->setBorder("A7:N7", 'thin');
                        $sheet->setBorder("A8:N8", 'thin');
                        $j = 8;
                        $i = 1;
                        $k = 8;
                        foreach ($customer_info as $customer) {
                            $resto_name = $customer->first_name . " " . $customer->last_name;
                            $sheet->row($k++, array(
                                $i++, $customer->orderid, $customer->order_total, $resto_name, $customer->delivery_prefer_time, $customer->comment, $customer->address_line1, $customer->address_line2, $customer->street, $customer->locality_name, $customer->city_name, $customer->pin_code
                            ));
                            $sheet->setBorder("A$k:N$k", 'thin');
                        }
                    });
                });
        $excelOperation->export('xls');
    }

    public function postOrdercustomerlocality(Request $request) {

        $locality = $request->get('locality');

         $locality_id = '["' . implode('", "', $locality) . '"]';
         $date = date("Y-m-d", strtotime($request->get('orderdate')));
        $customer_info = DB::table('orders as O')
                ->whereDate('O.created_at', '=', $date)
                ->whereIn('A.zone_id', $locality)
                ->join('customers as C', 'O.customer_id', '=', 'C.id')
                ->join('address as A', 'A.customer_id', '=', 'C.id')
                ->join('locality as L', 'L.id', '=', 'A.locality_id')
                ->join('city', 'city.id', '=', 'L.city_id')
				->join('zones as Z' ,'Z.id','=','A.zone_id')
                ->selectRaw('C.first_name,C.last_name,C.delivery_prefer_time,O.id as orderid,O.comment,O.order_total,A.address_line1,A.address_line2,A.street,A.pin_code,L.locality_name,city.city_name,A.zone_id,Z.zone')
				->whereNull('O.deleted_at')
                ->orderBy('A.zone_id')
				->orderBy('C.delivery_prefer_time')
                ->get();
      //  dd($customer_info);


        $excelOperation = Excel::create('custoemerdetails', function($excel) use($customer_info) {

                    $excel->setTitle('Customer Details as per order');
                    $excel->setCreator('Agro7')->setCompany('Agro7 Wholesale');
                    // $excel->setDescription('Stock Summary file');

                    $excel->sheet("Sheet", function($sheet) use($customer_info) {
                        $sheet->setOrientation('portrait');
                        // Set top, right, bottom, left
                        $sheet->setPageMargin(array(
                            0.354, 0.196, 0.157, 0.433
                        ));
                        $sheet->mergeCells('A1:N1');
                        $sheet->setCellValue('A1', 'Transven Lifestyle Management Private Limited');
                        $sheet->setBorder('A1:N1', 'thin');
                        $sheet->cells('A1:N1', function($cells) {

                            // manipulate the range of cells
                            // Set font size
                            $cells->setFontSize(16);

                            // Set font weight to bold
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                        });

                        $sheet->mergeCells('A2:N2');
                        $sheet->setCellValue('A2', ' ');
                        $sheet->cells('A2:N2', function($cells) {

                            // manipulate the range of cells
                            // Set font size
                            $cells->setFontSize(16);

                            // Set font weight to bold
                            $cells->setFontWeight('bold');
                            $cells->setAlignment('center');
                        });
                        $sheet->mergeCells('A3:N3');
                        $sheet->setCellValue('A3', 'Customer List');
                        $sheet->setBorder('A1:N3', 'thin');
                        $sheet->cells('A3:N3', function($cells) {

                            // manipulate the range of cells
                            // Set font size
                            $cells->setFontSize(16);
                            $cells->setAlignment('center');
                        });
                        //  C.first_name,C.last_name,C.delivery_prefer_time,O.id as orderid,O.comment,A.address_line1,A.address_line2,A.street,A.pin_code,L.locality_name,city.city_name
                        $sheet->row(7, array(
                            'Sr. No.', 'Order id', 'Order Total', 'Restorent Name', 'delivery_prefer_time', 'order comment', 'Address '
                        ));
                        $sheet->setBorder("A7:N7", 'thin');
                        $sheet->setBorder("A8:N8", 'thin');
                        $j = 8;
                        $i = 1;
                        $k = 8;
						$zone_id = 0;
                        foreach ($customer_info as $customer) {

							 if($zone_id  != $customer->zone_id)	
							 {
								$zone_id = $customer->zone_id;
								$zone_name = $customer->zone;
								for($v=1;$v<=5; $v++){
									if($v==4){
									$sheet->mergeCells("A$k:G$k");
                        			$sheet->setCellValue("A$k",$zone_name);
			                        $sheet->setBorder("A$k:G$k", 'thin');
                        			$sheet->cells("A$k:G$k", function($cells) {

									// manipulate the range of cells
									// Set font size
									$cells->setFontSize(16);
									$cells->setAlignment('left');
								});
									}
									$k++;
								  //$sheet->mergeCells("A$k:G$k");
								  //$sheet->row($k++, array('', '', '', '', '', '', ''));
								}
							}
								
							
                            $resto_name = $customer->first_name . " " . $customer->last_name;
							$address = $customer->address_line1. " " . $customer->address_line2 . " " .$customer->street. " ".$customer->locality_name ." ". $customer->city_name . " ".$customer->pin_code ;
                            $sheet->row($k++, array(
                                $i++, $customer->orderid, $customer->order_total, $resto_name, $customer->delivery_prefer_time, $customer->comment, $address
                            ));
							
                            $sheet->setBorder("A$k:N$k", 'thin');
                        }
                    });
                });
        $excelOperation->export('xls');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class procurementgeneralController extends Controller {

    //

    public function getProcurement() {
        // print_r($_GET);
        $date = $_GET['orderdate'];
        $date = date("Y-m-d", strtotime($date));
//        $customer_info = DB::table('orders as O')
//                ->whereDate('O.created_at', '=', $date)
//                ->join('customers as C', 'O.customer_id', '=', 'C.id')
//                ->join('address as A', 'A.customer_id', '=', 'C.id')
//                ->join('locality as L', 'L.id', '=', 'A.locality_id')
//                ->join('city', 'city.id', '=', 'L.city_id')
//                ->selectRaw('C.first_name,C.last_name,C.delivery_prefer_time,O.id as orderid,O.comment,A.address_line1,A.address_line2,A.street,A.pin_code,L.locality_name,city.city_name')
//                ->orderBy('O.id')
//                ->toSql();
//        dd($customer_info);
        //SELECT P.id,P.product_name FROM `order_details` OD join products P on P.id = OD.product_id where date(OD.created_at) = '2017-02-19' ORDER BY `id` DESC
        $products = DB::table('order_details as OD')
                ->whereDate('OD.created_at', '=', $date)
                ->selectRaw('OD.product_id,OD.product_name,OD.actual_uom,OD.qty,OD.product_total')
                ->orderBy('OD.id')
                ->get();

        //print_r($products);
        $order_procurement='';
        foreach ($products as $product) {
            $order_procurement .='<tr><td style="width: 275px; height: 50px;">
                                      <div class="col-md-4" style="position:absolute;">
                                                            <select style="width: 228px !important"  name="product[product_name][]" class="custom-select demo" data-placeholder="Select...">
                                                                <option value="">Please Select</option>
                                                                <option value=' . $product->product_id . ' selected>' . $product->product_name . '</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td style="width: 275px; height: 50px;">

                                                        <div class="col-md-4" style="position:absolute;">
                                                            <select style="width: 228px !important"  name="attribute[uom][]" class="custom-select demo" data-placeholder="Select...">
                                                                <option value="">Please Select</option>
                                                                <option value=' . $product->actual_uom . ' selected>' . $product->actual_uom . '</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control input-circle"  name="attribute[purchase_qty][]" placeholder="Qty" value=' . $product->qty . '>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control input-circle" placeholder="price" value=' . $product->product_total . '>   
                                                    </td>
                                                    <td>
                                                        <a href="javascript:;" class="btn default btn-xs purple remove">
                                                            <i class="fa fa-edit"></i> Re-move </a>
                                                    </td>
                                                </tr>
                                               ';
        }
        echo $order_procurement;
    }

}

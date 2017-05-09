<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderHistory;
use App\OrderDetailHistory;
use Activity;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'History';
    public function index()
    {
        if(Auth::user()->hasRole(['agent','admin' ,'owner']))
        {  
             Activity::log('user at orders History list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.orderHistory.index',compact('menu'));
        }else
             return redirect()->route('backhome')->with("message",'You Don\'t have permission');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //Activity::log('user at  create orders successfully ', Auth::id());
        if($request->has('created_by'))
        {
            $created_by = $request->get('created_by');
        }else{
            $created_by=0;
        }

        if($request->has('updated_by'))
        {
            $updated_by = $request->get('updated_by');
        }else{
            $updated_by=0;
        }

        $orderHistoryInsert = [
            //'order_by' => $request->get('last_name'),
            'order_id' => $request->get('order_id'),
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'order_total' => $request->get('grand_total'),
            'sub_total' => $request->get('sub_total'),
            'delivery_charge' => $request->get('delivery_charge'),
            'created_at' => $request->get('created_at'),
            'order_stage' => $request->get('order_stage'),
            'comment' => $request->get('order_comment'),
            'remark' => $request->get('remark'),
            'created_by' => $created_by,
            'updated_by' => $updated_by,
        ];

        //Adding Orders
        if($request->has('price')){
            $newval = $request->get('price');
            $price = array();
            foreach ($newval as $key => $item) {

            array_push($price, $item);
            
            }
        }

         $orderHistory = OrderHistory::create($orderHistoryInsert);

            for($i=0; $i< count($request->get('product_id')); $i++){
                $product_id = $request->get('product_id')[$i];
                if( isset($product_id) && $product_id!='' ){
                    $orderDetail = new OrderDetailHistory;
                    $attribute = trim($request->get('attribute_name')[$i]);
                    $attribute_array = explode(' ',$attribute );
                    $orderDetail->order_id = $request->get('order_id');
                    $orderDetail->actual_mrp = $price[$i];
                    $orderDetail->price_type = $request->get('price_type')[$i];
                    $orderDetail->actual_attribute_name = isset($attribute_array[0])?$attribute_array[0]:$attribute;
                    $orderDetail->actual_uom = isset($attribute_array[1])?$attribute_array[1]:$attribute;
                    $orderDetail->qty = $request->get('qty')[$i];
                    $orderDetail->product_total = $request->get('product_total')[$i];
                    $orderDetail->product_id = $request->get('product_id')[$i];
                    $orderDetail->product_name = $request->get('product_name')[$i];
                    $orderDetail->attribute_id = $request->get('attribute_id')[$i];
                   // $orderDetail->comment = $request->get('order_detail_comment')[$i];

                    $orderHistory->orderDetailHistory()->save($orderDetail);

                    //updating stock Start
                    /* $stock = Stock::where('attribute_id','=',$request->get('attribute_id')[$i])->where('product_id','=', $product_id)->get()->first();

                    $stockUpdate = [
                    'total_qty_in_hand' =>  $stock->total_qty_in_hand -  $request->get('qty')[$i],
                    ];

                    $stock->update($stockUpdate);
                    //updating stock Ends
                    */
                }
            }

            //Adding edited order Detials
            if(count($request->get('edit_order_detail_id')) > 0)
            {
                $edit_newval = $request->get('edit_price');
                $edit_price = array();
                foreach ($edit_newval as $key => $item) {
                    array_push($edit_price, $item);
                }
            }

            for($i=0; $i< count($request->get('edit_order_detail_id')); $i++){
                $orderDetail_id = $request->get('edit_order_detail_id')[$i];
                $delete_status = isset($request->get('delete_order_detail')[$i])?$request->get('delete_order_detail')[$i]:'False';

                
                if($delete_status == 'True'){
                //DELETING ORDER DETAILS
                   // OrderDetail::find($orderDetail_id)->delete();
                }else{
                //UPDATING ORDER DETAILS

                    $orderDetail = new OrderDetailHistory;
                    $attribute = trim($request->get('edit_attribute_name')[$i]);
                    $attribute_array = explode(' ',$attribute);
                    $orderDetail->order_id = $request->get('order_id');
                    $orderDetail->actual_mrp = $edit_price[$i];
                    $orderDetail->price_type = $request->get('edit_price_type')[$i];
                    $orderDetail->actual_attribute_name = isset($attribute_array[0])?$attribute_array[0]:$attribute;
                    $orderDetail->actual_uom = isset($attribute_array[1])?$attribute_array[1]:$attribute;
                    $orderDetail->qty = $request->get('edit_qty')[$i];
                    $orderDetail->product_total = $request->get('edit_product_total')[$i];
                    $orderDetail->product_id = $request->get('edit_product_id')[$i];
                    $orderDetail->product_name = $request->get('edit_product_name')[$i];
                    $orderDetail->attribute_id = $request->get('edit_attribute_id')[$i];
                   // $orderDetail->comment = $request->get('order_detail_comment')[$i];

                    $orderHistory->orderDetailHistory()->save($orderDetail);
                }

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Activity::log('user at  view order History ', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_order') ){
            $order = Order::find($id);
            $orderHistory =  $order->orderHistory;

           // dd($orderHistory);
             $menu = $this->menu;
            return view('pages.orderHistory.show',compact(['order','orderHistory','menu']));
        }else
             return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

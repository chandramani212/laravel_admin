<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\OrderRequest;
use App\Customer;
use App\Order;
use App\OrderDetail;
use App\Stock;
use App\OrderDetailComment;
use Activity;
use Illuminate\Support\Facades\Auth;
class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Ecommerce';
    public function index()
    {
        if(Auth::user()->hasRole(['agent','admin' ,'woner']))
        {  
             Activity::log('user at invoices list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.invoices.index',compact('menu'));
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
        Activity::log('user at  create orders ', Auth::id());   
        //
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('create_order') ){

            $customers =  Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
            $customerOption[""] = 'Choose Customer';
            foreach ($customers as $customer) {
                $customerOption["$customer->id"] =  $customer->first_name.' '.$customer->last_name ;
            }

            //dd($customerOption);
             $menu = $this->menu;
            return view('pages.orders.create',compact('customerOption','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
         Activity::log('user at  create orders successfully ', Auth::id());
        $orderInsert = [
            //'order_by' => $request->get('last_name'),
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'order_total' => $request->get('grand_total'),
            'sub_total' => $request->get('sub_total'),
            'delivery_charge' => $request->get('delivery_charge'),
            'created_at' => $request->get('created_at'),
            'order_stage' => 'CREATED',
            'created_by' =>Auth::id(),
        ];

        $newval = $request->get('price');
        $price = array();
        foreach ($newval as $key => $item) {

        array_push($price, $item);
        
        }

  
        $order = Order::create($orderInsert);
       // dd($request);

        for($i=0; $i< count($request->get('product_id')); $i++){
            $product_id = $request->get('product_id')[$i];
            if( isset($product_id) && $product_id!='' ){
                $orderDetail = new OrderDetail;
                $attribute = trim($request->get('attribute_name')[$i]);
                $attribute_array = explode(' ',$attribute );
                $orderDetail->actual_mrp = $price[$i];
                $orderDetail->price_type = $request->get('price_type')[$i];
                $orderDetail->actual_attribute_name = $attribute_array[0];
                $orderDetail->actual_uom = $attribute_array[1];
                $orderDetail->qty = $request->get('qty')[$i];
                $orderDetail->product_total = $request->get('product_total')[$i];
                $orderDetail->product_id = $request->get('product_id')[$i];
                $orderDetail->product_name = $request->get('product_name')[$i];
                $orderDetail->attribute_id = $request->get('attribute_id')[$i];

                $order->orderDetails()->save($orderDetail);

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

        return redirect()->route('order.index')
                       ->with('success','Order created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Activity::log('user at  view Invoice ', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_order') ){
            $order = Order::find($id);
            $orderDetails = Order::find($id)->orderDetails;
            $customer = Order::find($id)->customer;
            $shippingAddress = Order::find($id)->address;
             $menu = $this->menu;
            return view('pages.invoices.show',compact(['order','orderDetails','customer','shippingAddress','menu']));
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
        Activity::log('user at  Edit Invoice successfully ', Auth::id());

        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_order') ){
            $order = Order::find($id);
            $customers = Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
            $address =  Customer::find($order->customer_id)->address;
            $orderDetails = Order::find($id)->orderDetails;
            $customerOption[""] = 'Choose Customer';
            foreach ($customers as $customer) {
                $customerOption["$customer->id"] =  $customer->first_name.' '.$customer->last_name ;
            };

            foreach ($address as $addres) {

                $city_name = isset($addres->city->city_name)?$addres->city->city_name:'';
                $locality_name = isset($addres->locality->locality_name)?$addres->locality->locality_name:'';
                $state_name = isset($addres->state->state_name)?$addres->state->state_name:'';

                $addressOption["$addres->id"] =  $addres->address_line1.' '.$addres->address_line2.' '.$addres->street.' '.$addres->pin_code.' '. $city_name.' '. $locality_name.' '. $state_name;
            }

             $menu = $this->menu;
            return view('pages.invoices.edit',compact(['order','orderDetails','customerOption','addressOption','menu']));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
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
        //dd($request);
        Activity::log('user at  update Invoice successfully ', Auth::id());

        $order_stage = $request->get('order_stage');

       // dd($order_stage);

        if( $order_stage !="" &&  $order_stage !==null)
        {

            $orderUpdate = [
                'order_stage' => $order_stage,
                'updated_by' => Auth::id(),
            ];

           $orderUpdate =  Order::find($id)->update($orderUpdate);
        }
       
        

        //$order = Order::find($id);
        //dd($request);

            for($i=0; $i< count($request->get('edit_order_detail_id')); $i++){
                $orderDetail_id = $request->get('edit_order_detail_id')[$i];

                 //echo "Details id:".$orderDetail_id;
               
                ### Deleting and Editing Order Details Comments Start ###
                if(isset($request->get('edit_order_detail_comment_id')[$orderDetail_id])){
                for($j=0; $j< count( $request->get('edit_order_detail_comment_id')[$orderDetail_id]); $j++){

                    $orderDetailComment_id = $request->get('edit_order_detail_comment_id')[$orderDetail_id][$j];
                    $delete_status = isset($request->get('delete_order_detail_comment')[$orderDetail_id][$j])?$request->get('delete_order_detail_comment')[$orderDetail_id][$j]:'False';

                    
                    if($delete_status == 'True'){
                    //DELETING ORDER DETAILS COMMENT
                        OrderDetailComment::find($orderDetailComment_id)->delete();
                    }else{

                    //UPDATING ORDER DETAILS COMMENT
                  
                    $orderDetailCommentUpdate = [
                    'qc_comment' => $request->get('edit_order_detail_qc_comment')[$orderDetail_id][$j],
                    'comment_status' => $request->get('edit_order_detail_qc_comment_status')[$orderDetail_id][$j],
                    'updated_by' =>  Auth::id(),
                    ];

                    OrderDetailComment::find($orderDetailComment_id)->update($orderDetailCommentUpdate);

                    }
                }
                }
                ### Deleting and Editing Order Details Comments Ends ###


                ### Addig Order Details Comments Start ###
                for($j=0; $j< count( $request->get('order_detail_qc_comment')[$orderDetail_id]); $j++){

                    if($request->get('order_detail_qc_comment')[$orderDetail_id][$j] != '')
                    {
                        $orderDetailComment =  new OrderDetailComment();

                        $orderDetailComment->qc_comment =  $request->get('order_detail_qc_comment')[$orderDetail_id][$j];

                        $orderDetailComment->comment_status =  $request->get('order_detail_qc_comment_status')[$orderDetail_id][$j];

                        $orderDetailComment->created_by =  Auth::id();

                        OrderDetail::find($orderDetail_id)->orderDetailComments()->save($orderDetailComment);
                    }
                }
                ### Addig Order Details Comments Ends ###

                

            }

            //exit;
     
        return redirect()->route('invoice.index')
                        ->with('success','Invoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Activity::log('user at  Delete Invoice successfully ', Auth::id());
         if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_order') ){
            Order::find($id)->delete();
            return redirect()->route('order.index')
                            ->with('success','Order deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

}

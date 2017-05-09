<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use App\Http\Requests;
use App\Http\Requests\OrderRequest;
use App\Customer;
use App\Order;
use App\OrderDetail;
use App\OrderDetailComment;
use App\Stock;
use Activity;
use App\Http\Controllers\Api\Tookan\TookanApiBuilderController;

class OrderController extends Controller
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
             Activity::log('user at orders list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.orders.index',compact('menu'));
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

             $current_time = date('H:i:s');
             $split = explode(":",$current_time);
             if($split[0]>=10 && $split[0] <24){
                $order_date = date('Y-m-d', strtotime('+1 day') );
             }else{

                 $order_date = date('Y-m-d');
             }


            return view('pages.orders.create',compact('customerOption','menu','order_date'));
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
         $createdDate =  $request->get('created_at').' '.date('H:i:s');
        $orderInsert = [
            //'order_by' => $request->get('last_name'),
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'order_total' => $request->get('grand_total'),
            'sub_total' => $request->get('sub_total'),
            'delivery_charge' => $request->get('delivery_charge'),
            'created_at' => $createdDate,
            'order_stage' => 'CREATED',
            'comment' => $request->get('order_comment'),
            'remark' => $request->get('remark'),
            'pi_no' => $request->get('pi_no'),
            'created_by' =>Auth::id(),
        ];

        $newval = $request->get('price');
        $price = array();
        foreach ($newval as $key => $item) {

        array_push($price, $item);
        
        }

  
        $order = Order::create($orderInsert);

        if(isset($order->id) && $order->id >0 ){
         
            ### Creating History of Orders Start ###
            $request->request->add(['order_id'=> $order->id]);
            $request->request->add(['order_stage'=> 'CREATED']);
            $request->request->add(['created_by'=> Auth::id()]);
            $orderHistory = new OrderHistoryController;
            $orderHistory->store($request);
            ### Creating History of Orders END ###

            for($i=0; $i< count($request->get('product_id')); $i++){
                $product_id = $request->get('product_id')[$i];
                if( isset($product_id) && $product_id!='' ){
                    $orderDetail = new OrderDetail;
                    $attribute = trim($request->get('attribute_name')[$i]);
                    $attribute_array = explode(' ',$attribute );
                    $orderDetail->actual_mrp = $price[$i];
                    $orderDetail->price_type = $request->get('price_type')[$i];
                    $orderDetail->actual_attribute_name = $attribute_array[0];
                    $orderDetail->actual_uom = isset($attribute_array[1])?$attribute_array[1]:0;
                    $orderDetail->qty = $request->get('qty')[$i];
                    $orderDetail->product_total = $request->get('product_total')[$i];
                    $orderDetail->product_id = $request->get('product_id')[$i];
                    $orderDetail->product_name = $request->get('product_name')[$i];
                    $orderDetail->attribute_id = $request->get('attribute_id')[$i];
                   // $orderDetail->comment = $request->get('order_detail_comment')[$i];
                    $orderDetail->created_at = $createdDate;

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

            if(Config::get('tookan.status') == 'enable'){
                $tookanApi = new TookanApiBuilderController;
                $tookanApi->createTask($order);
            }
            return redirect()->route('order.index')
                       ->with('success','Order created successfully');
        }else{

            return redirect()->route('order.index')
                       ->with('success','Unable to create order');
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
        Activity::log('user at  view orders ', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_order') ){
            $order = Order::find($id);
            if($order){
                $orderDetails = Order::find($id)->orderDetails;
                $customer = Order::find($id)->customer;
                $shippingAddress = Order::find($id)->address;
                 $menu = $this->menu;
                return view('pages.orders.show',compact(['order','orderDetails','customer','shippingAddress','menu']));
            }else{

               return redirect()->route('order.index')->with("message",'Order Not Exists');

            }
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
        Activity::log('user at  Edit orders successfully ', Auth::id());

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
            return view('pages.orders.edit',compact(['order','orderDetails','customerOption','addressOption','menu']));
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
        Activity::log('user at  update orders successfully ', Auth::id());

        $this->validate($request, [
            'customer_id' => 'required',
        ]);

        $createdDate =  $request->get('created_at').' '.date('H:i:s');
        $orderUpdate = [
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'order_total' => $request->get('grand_total'),
            'sub_total' => $request->get('sub_total'),
            'delivery_charge' => $request->get('delivery_charge'),
            'created_at' =>  $createdDate,
            'order_stage' => 'UPDATED',
            'comment' => $request->get('order_comment'),
            'remark' => $request->get('remark'),
            'pi_no' =>  $request->get('pi_no'),
            'updated_by' => Auth::id()
   
        ];

    //$request->request->add(['order_id'=> $id]);

    //dd($request);

       $orderUpdate =  Order::find($id)->update($orderUpdate);

       if( $orderUpdate ){

            ### Creating History of Orders Start ###
           $request->request->add(['order_id'=> $id]);
            $request->request->add(['order_stage'=> 'UPDATED']);
            $request->request->add(['updated_by'=> Auth::id()]);
            $orderHistory = new OrderHistoryController;
            $orderHistory->store($request);
            ### Creating History of Orders END ###

            //EDITING AND DELETING ORDER DETAILS
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
                    OrderDetail::find($orderDetail_id)->delete();
                }else{
                //UPDATING ORDER DETAILS
				
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
					
                    $attribute = trim($request->get('edit_attribute_name')[$i]);
                    $attribute_array = explode(' ',$attribute);
                    $orderDetailUpdate = [
                    'actual_mrp' => $edit_price[$i],
                    'price_type' => $request->get('edit_price_type')[$i],
                    'actual_attribute_name' =>  $attribute_array[0],
                    'actual_uom'=> isset($attribute_array[1])?$attribute_array[1]:0,
                    'qty'=> $request->get('edit_qty')[$i],
                    'product_total'=> $request->get('edit_product_total')[$i],
                    'product_id'=> $request->get('edit_product_id')[$i],
                    'product_name'=> $request->get('edit_product_name')[$i],
                    'attribute_id'=> $request->get('edit_attribute_id')[$i],
                    //'comment'=> $request->get('order_detail_comment')[$i],
                    'created_at'=> $createdDate
                    ];

                    OrderDetail::find($orderDetail_id)->update($orderDetailUpdate);
                }

            }

            //Adding order 
            if(count($request->get('product_id'))>0)
            {
                $newval = $request->get('price');
                $price = array();
                foreach ($newval as $key => $item) {
                    array_push($price, $item);
                }
            }

            $order = Order::find($id);
            for($i=0; $i< count($request->get('product_id')); $i++){
                $product_id = $request->get('product_id')[$i];
                if( isset($product_id) && $product_id!='' ){

                    $orderDetail = new OrderDetail;
                    $attribute = trim($request->get('attribute_name')[$i]);
                    $attribute_array = explode(' ',$attribute );
                    $orderDetail->actual_mrp = $price[$i];
                    $orderDetail->price_type = $request->get('price_type')[$i];
                    $orderDetail->actual_attribute_name = $attribute_array[0];
                    $orderDetail->actual_uom = isset($attribute_array[1])?$attribute_array[1]:0;
                    $orderDetail->qty = $request->get('qty')[$i];
                    $orderDetail->product_total = $request->get('product_total')[$i];
                    $orderDetail->product_id = $request->get('product_id')[$i];
                    $orderDetail->product_name = $request->get('product_name')[$i];
                    $orderDetail->attribute_id = $request->get('attribute_id')[$i];
                    //$orderDetail->comment = $request->get('order_detail_comment')[$i];
                    $orderDetail->created_at = $createdDate;

                    $order->orderDetails()->save($orderDetail);
                }
            }

            if(Config::get('tookan.status') == 'enable'){
                $tookanApi = new TookanApiBuilderController;
                $tookanApi->editTask($order);
             }

            return redirect()->route('order.index')
                            ->with('success','Order updated successfully');

           
        }else{


            return redirect()->route('order.index')
                        ->with('success','Unable to update Order successfully');
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Activity::log('user at  Delete orders successfully ', Auth::id());
         if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_order') ){
            Order::find($id)->delete();

            if(Config::get('tookan.status') == 'enable'){
                $tookanApi = new TookanApiBuilderController;
                $tookanApi->deleteTaskByORderId($id);
            }

            return redirect()->route('order.index')
                            ->with('success','Order deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

}

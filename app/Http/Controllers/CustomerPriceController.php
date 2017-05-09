<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CustomerPriceRequest;
use App\Customer;
use App\Address;
use App\CustomerProductAttributePrice;
use App\CustomerProductAttributePriceDetail;

use Activity;
use Illuminate\Support\Facades\Auth;
class CustomerPriceController extends Controller
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
             Activity::log('user at Customer Specific price list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.customerPrice.index',compact('menu'));
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
        Activity::log('user at  create Customer specific price ', Auth::id());   
        //
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('create_order') ){

            $customers =  Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
            $customerOption[""] = 'Choose Customer';
            foreach ($customers as $customer) {
                $customerOption["$customer->id"] =  $customer->first_name.' '.$customer->last_name ;
            }

            //dd($customerOption);
             $menu = $this->menu;

            return view('pages.customerPrice.create',compact('customerOption','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerPriceRequest $request)
    {
         Activity::log('user at  create customer Specific price successfully ', Auth::id());


        $date_range = explode('/',$request->get('date_range') );

        $customerPriceInsert = [
            //'order_by' => $request->get('last_name'),
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'start_date' =>  trim($date_range[0]),
            'end_date' =>  trim($date_range[1]),
            'status' => '1',
            'created_by' =>Auth::id(),
        ];
  
        $customerPrice = CustomerProductAttributePrice::create($customerPriceInsert);

        if(isset($customerPrice->id) && $customerPrice->id >0 ){
            for($i=0; $i< count($request->get('product_id')); $i++){
                $product_id = $request->get('product_id')[$i];
                if( isset($product_id) && $product_id!='' ){
                    $custPriceDetail = new CustomerProductAttributePriceDetail;

                    $custPriceDetail->product_id = $request->get('product_id')[$i];
                    $custPriceDetail->attribute_id = $request->get('attribute_id')[$i];
                    $custPriceDetail->price = $request->get('price')[$i];
                    $custPriceDetail->default_selected_price = $request->get('default_selected_price')[$i];
                    $custPriceDetail->created_by = Auth::id();

                    $customerPrice->priceDetails()->save($custPriceDetail);
                }

            }

            return redirect()->route('customerPrice.index')
                       ->with('success','Price added successfully');
        }else{

            return redirect()->route('customerPrice.index')
                       ->with('success','Unable to create Customer Specific price');
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
        Activity::log('user at  view of customer specific price ', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_order') ){

            $customerPrice = CustomerProductAttributePrice::find($id);

            //dd( $customerPrice);
            if($customerPrice){

                $shippingAddress  = $customerPrice->address ;
                $customer  = $shippingAddress->customer;

                $custPriceDetails = $customerPrice->priceDetails;

                 $menu = $this->menu;
                return view('pages.customerPrice.show',compact(['customerPrices','customer','shippingAddress','custPriceDetails','menu']));
            }else{

               return redirect()->route('customerPrice.index')->with("message",'Customer Specific Price Not Exists Please create First');

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

        Activity::log('user at  Edit Customer Price successfully ', Auth::id());

        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_order') ){
            
            $menu = $this->menu;
            $customerPrice = CustomerProductAttributePrice::find($id);
            
            if($customerPrice){

                $customers = Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
                $address = Address::all();
               
                $custPriceDetails = $customerPrice->priceDetails;

                return view('pages.customerPrice.edit',compact(['customerPrice','customers','custPriceDetails','address','menu']));

            }else{

                return redirect()->route('customerPrice.index')->with("message",'Customer Specific Price Not Exists Please create First');
            }

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
    public function update(CustomerPriceRequest $request,$id)
    {
        //dd($request);
        Activity::log('user at  update customer price edit successfully ', Auth::id());

       /* $this->validate($request, [
            'customer_id' => 'required',
        ]);*/
         $date_range = explode('/',$request->get('date_range') );
         $customerPriceUpdate = [
           
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'start_date' => $date_range[0],
            'end_date' => $date_range[1],
            'updated_by' =>Auth::id(),
   
        ];

        $custPriceUpdate = CustomerProductAttributePrice::find($id)->update($customerPriceUpdate);

        if( $custPriceUpdate )
        {
            ### Editing Customer Price Details Start ###
            for($i=0; $i< count($request->get('edit_customer_price_detail_id')); $i++){
                    $custPriceDetail_id = $request->get('edit_customer_price_detail_id')[$i];
                    $delete_status = isset($request->get('delete_customer_price_detail')[$i])?$request->get('delete_customer_price_detail')[$i]:'False';

                    
                    if($delete_status == 'True'){
                    //DELETING CUSTOMER PRICE 
                        CustomerProductAttributePriceDetail::find($custPriceDetail_id)->delete();
                        
                    }else{
                    //UPDATING CUSTOMER PRICE 

                        $custPriceDetailUpdate = [
                        'product_id' => $request->get('edit_product_id')[$custPriceDetail_id],
                        'attribute_id' => $request->get('edit_attribute_id')[$custPriceDetail_id],
                        'price' => $request->get('edit_price')[$custPriceDetail_id] , 
                        'default_selected_price' => $request->get('edit_default_selected_price')[$custPriceDetail_id], 
                        'updated_by' => Auth::id(),
                        ];

                        CustomerProductAttributePriceDetail::find($custPriceDetail_id)->update($custPriceDetailUpdate);

                    }
            }
            ### Editing Customer price details End ###

            ### Adding Customer price details Start ###
            $customerPrice = CustomerProductAttributePrice::find($id);
            for($i=0; $i< count($request->get('product_id')); $i++){
                $product_id = $request->get('product_id')[$i];
                if( isset($product_id) && $product_id!='' ){
                    $custPriceDetail = new CustomerProductAttributePriceDetail;

                    $custPriceDetail->product_id = $request->get('product_id')[$i];
                    $custPriceDetail->attribute_id = $request->get('attribute_id')[$i];
                    $custPriceDetail->price = $request->get('price')[$i];
                    $custPriceDetail->default_selected_price = $request->get('default_selected_price')[$i];
                    $custPriceDetail->created_by = Auth::id();

                    $customerPrice->priceDetails()->save($custPriceDetail);
                }

            }
            ### Adding Customer price details Start ###
            
            return redirect()->route('customerPrice.index')
                            ->with('success','Order Updated successfully');

        }
        else{


            return redirect()->route('customerPrice.index')
                        ->with('success','Unable to update  successfully');
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
        Activity::log('Customer Price at  Delete orders successfully ', Auth::id());
         if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_order') ){
            
            CustomerProductAttributePrice::where('address_id',$id)->delete();
            return redirect()->route('customerPrice.index')
                            ->with('success','Customer Price deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

}

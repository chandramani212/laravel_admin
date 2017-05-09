<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CustomPriceRequest;
use App\Customer;
use App\Product;
use App\Address;
use App\CustomPrice;
use App\CustomPriceList;
use App\CustomerCustomPrice;


use Activity;
use Illuminate\Support\Facades\Auth;
class CustomPriceController extends Controller
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
             Activity::log('user at Custom price list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.customPrice.index',compact('menu'));
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

            $customers =  Customer::orderBy('first_name','ASC')
                                    ->orderBy('last_name','ASC')
                                    ->get(['id','first_name','last_name']);

            //$products =  Product::orderBy('product_name','ASC')
            //                        ->get(['id','product_name']);

            $customerOption[""] = 'Choose Customer';
            foreach ($customers as $customer) {
                $customerOption["$customer->id"] =  $customer->first_name.' '.$customer->last_name ;
            }

            //dd($customerOption);
             $menu = $this->menu;

            return view('pages.customPrice.create',compact('customerOption','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomPriceRequest $request){

         Activity::log('user at  create customer Specific price successfully ', Auth::id());

        // dd($request);
        $customPriceInsert = [
            'description' =>  $request->get('description')
        ];

        $customPrice = CustomPrice::create($customPriceInsert);

        if(isset($customPrice->id) && $customPrice->id >0 ){

            //adding  to table customer_custom_price
            for($i=0; $i< count($request->get('customer_id')); $i++){
                $customer_id = $request->get('customer_id')[$i];

                $date_range =  explode('/',$request->get('date_range')[$i] );

                $custCustomPrice = new CustomerCustomPrice;

                $custCustomPrice->customer_id = $request->get('customer_id')[$i];
                $custCustomPrice->address_id = $request->get('address_id')[$i];
                $custCustomPrice->start_date = trim($date_range[0]);
                $custCustomPrice->end_date = trim($date_range[1]);

                $customPrice->customerCustomPrices()->save($custCustomPrice);

            }

            //adding  to table custom_price_list
            for($i=0; $i< count($request->get('product_id')); $i++){
                $product_id = $request->get('product_id')[$i];
                if( isset($product_id) && $product_id!='' ){
                    $custPriceDetail = new CustomPriceList;

                    $custPriceDetail->product_id = $request->get('product_id')[$i];
                    $custPriceDetail->attribute_id = $request->get('attribute_id')[$i];
                    $custPriceDetail->price = $request->get('price')[$i];
                    $custPriceDetail->default_selected_price = $request->get('default_selected_price')[$i];
                    $custPriceDetail->created_by = Auth::id();

                    $customPrice->customPriceLists()->save($custPriceDetail);
                }
            }

            return redirect()->route('customPrice.index')
                       ->with('success','Price added successfully');

        }else{

            return redirect()->route('customPrice.index')
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

            $customPrice = CustomPrice::find($id);

            //dd( $customerPrice);
            if($customPrice){

                $customerLists = $customPrice->customerCustomPrices;
                $customPriceLists = $customPrice->customPriceLists;


                //dd($customPriceLists );
                 $menu = $this->menu;
                return view('pages.customPrice.show',compact(['customPrice','customerLists','customPriceLists','menu']));
            }else{

               return redirect()->route('customPrice.index')->with("message",'Customer Specific Price Not Exists Please create First');

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
            $customPrice = CustomPrice::find($id);
            
            if($customPrice){

                $customerLists = $customPrice->customerCustomPrices;
                $customPriceLists = $customPrice->customPriceLists;
                $customers = Customer::all();

                return view('pages.customPrice.edit',compact(['customPrice','customerLists','customPriceLists','customers','menu']));

            }else{

                return redirect()->route('customPrice.index')->with("message",'Customer Specific Price Not Exists Please create First');
            }

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
    public function update(Request $request,$id)
    {
        //dd($request);
        Activity::log('user at  update customer price edit successfully ', Auth::id());

       /* $this->validate($request, [
            'customer_id' => 'required',
        ]);*/
        $customPriceInsert = [
            'description' =>  $request->get('description')
        ];
        $customPriceUpdate = CustomPrice::find($id)->update($customPriceInsert);


        if( $customPriceUpdate )
        {
            ### Editing Customer Custom list Details Start ###
            for($i=0; $i< count($request->get('edit_custom_price_list_id')); $i++){
                $custPriceList_id = $request->get('edit_custom_price_list_id')[$i];
                $delete_status = isset($request->get('delete_customer_custom_id')[$i])?$request->get('delete_customer_custom_id')[$i]:'False';

            
                if($delete_status == 'on'){
                    //DELETING CUSTOMER CUSTOM PRICE 

                        //echo 'deleteing '.$cusPriceList_id; exit;
                        CustomerCustomPrice::find($custPriceList_id)->delete();
                        
                    }else{
                    //UPDATING CUSTOMER CUSTOM PRICE 
                        $date_range = explode('/',$request->get('edit_date_range')[$custPriceList_id] );

                        $custPriceListUpdate = [
                        'customer_id' => $request->get('edit_customer_id')[$custPriceList_id],
                        'address_id' => $request->get('edit_address_id')[$custPriceList_id],
                        'start_date' => $date_range[0] , 
                        'end_date' => $date_range[1],
                        ];

                        CustomerCustomPrice::find($custPriceList_id)->update($custPriceListUpdate);
                    }

            }
            ### Editing Customer Custom list Details End ###


            ### Adding Customer price details Start ###
             $customPrice = CustomPrice::find($id);
            for($i=0; $i< count($request->get('customer_id')); $i++){

                $customer_id = $request->get('customer_id')[$i];
                if($customer_id !='' && !empty($customer_id) && $customer_id > 0){

                    $date_range =  explode('/',$request->get('date_range')[$i] );

                    $custCustomPrice = new CustomerCustomPrice;
                    $custCustomPrice->customer_id = $request->get('customer_id')[$i];
                    $custCustomPrice->address_id = $request->get('address_id')[$i];
                    $custCustomPrice->start_date = trim($date_range[0]);
                    $custCustomPrice->end_date = trim($date_range[1]);

                    $customPrice->customerCustomPrices()->save($custCustomPrice);
                }

            }
            ### Adding Customer price details Ends ###
  
            return redirect()->route('customPrice.index')
                            ->with('success','Order Updated successfully');

        }
        else{


            return redirect()->route('customPrice.index')
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
            
            CustomPrice::find($id)->delete();
            return redirect()->route('customPrice.index')
                            ->with('success','Customer Price deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

}

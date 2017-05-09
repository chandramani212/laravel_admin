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
class CustomPriceListController extends Controller
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
        /* if(Auth::user()->hasRole(['agent','admin' ,'woner']))
        {  
             Activity::log('user at Custom price list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.customPriceList.index',compact('menu'));
        }else
             return redirect()->route('backhome')->with("message",'You Don\'t have permission');
             */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*Activity::log('user at  create Customer specific price ', Auth::id());   
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

            return view('pages.customPriceList.create',compact('customerOption','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
            */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

         Activity::log('user at  create customer Specific price list successfully ', Auth::id());

        // dd($request);
        $customPriceListUpdate = [
            'product_id' =>  $request->get('product_id'),
            'attribute_id' =>  $request->get('attribute_id'),
            'price' =>  $request->get('price'),
            'default_selected_price' =>  $request->get('default_selected_price')
        ];

       // $id  = $request->get('id');

        $customPriceUpdate = CustomPriceList::find($id)->update($customPriceListUpdate);
        if($customPriceUpdate){
          echo 'SUCCESS';
        }else{
          echo 'FAIL';
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
        /*Activity::log('user at  view of customer specific price ', Auth::id());
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
             */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        /*
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
            */
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
        Activity::log('user at  update customer price  list edit successfully ', Auth::id());

       /* $this->validate($request, [
            'customer_id' => 'required',
        ]);*/
        $customPriceListUpdate = [
            'product_id' =>  $request->get('product_id'),
            'attribute_id' =>  $request->get('attribute_id'),
            'price' =>  $request->get('price'),
            'default_selected_price' =>  $request->get('default_selected_price')
        ];

        $customPriceUpdate = CustomPriceList::find($id)->update($customPriceListUpdate);


        if( $customPriceUpdate )
        {
            
            return true;

        }
        else{


            return false;
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CustomerPriceRequest;
use App\Customer;
use App\Address;
use App\PaymentReceipt;

use Activity;
use Illuminate\Support\Facades\Auth;
class PaymentReceiptController extends Controller
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
             Activity::log('user at PaymentReceipt list page', Auth::id());
            // $orders = Order::orderBy('id','DESC')->get();
             $menu = $this->menu;
            return view('pages.paymentReceipt.index',compact('menu'));
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

            $current_time = date('H:i:s');
            $split = explode(":",$current_time);
            $order_date = date('Y-m-d');
            /* if($split[0]>=10 && $split[0] <24){
                $order_date = date('Y-m-d', strtotime('+1 day') );
             }else{

                 $order_date = date('Y-m-d');
             }*/

            //dd($customerOption);
             $menu = $this->menu;

            return view('pages.paymentReceipt.create',compact('customerOption','menu','order_date'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         Activity::log('user at  create customer Specific price successfully ', Auth::id());


        $paymentReceiptInsert = [
            //'order_by' => $request->get('last_name'),
            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'amount' => $request->get('amount'),
            'paid_at' =>  $request->get('paid_at'),
            'payment_mode' =>  $request->get('payment_mode'),
            'payment_mode_no' =>  $request->get('payment_mode_no'),
        ];
  
        $paymentReceipt = PaymentReceipt::create($paymentReceiptInsert);

        if(isset($paymentReceipt->id) && $paymentReceipt->id >0 ){
           

            return redirect()->route('paymentReceipt.index')
                       ->with('success','Receipt added successfully');
        }else{

            return redirect()->route('paymentReceipt.index')
                       ->with('success','Unable to create Receipt');
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

            $paymentReceipt = PaymentReceipt::find($id);

            //dd( $customerPrice);
            if($paymentReceipt){

                $shippingAddress  = $paymentReceipt->address ;
                $customer  = $shippingAddress->customer;

                 $menu = $this->menu;
                return view('pages.paymentReceipt.show',compact(['paymentReceipt','customer','shippingAddress','menu']));
            }else{

               return redirect()->route('paymentReceipt.index')->with("message",' Receipt Not Exists Please create First');

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
            $paymentReceipt = PaymentReceipt::find($id);
            
            if($paymentReceipt){

                $customers = Customer::orderBy('id','ASC')->get(['id','first_name','last_name']);
                $address = Address::all();
               
               // $custPriceDetails = $customerPrice->priceDetails;

                return view('pages.paymentReceipt.edit',compact(['paymentReceipt','customers','address','menu']));

            }else{

                return redirect()->route('paymentReceipt.index')->with("message",'Customer Specific Price Not Exists Please create First');
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
        
         $paymentReceiptUpdate = [

            'customer_id' => $request->get('customer_id'),
            'address_id' => $request->get('address_id'),
            'amount' => $request->get('amount'),
            'paid_at' =>  $request->get('paid_at'),
            'payment_mode' =>  $request->get('payment_mode'),
            'payment_mode_no' =>  $request->get('payment_mode_no'),
   
        ];

        $paymentReceiptUpdate = PaymentReceipt::find($id)->update($paymentReceiptUpdate);

        if( $paymentReceiptUpdate )
        {
            
            return redirect()->route('paymentReceipt.index')
                            ->with('success','Receipt Updated successfully');
        }
        else{


            return redirect()->route('paymentReceipt.index')
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
            
            PaymentReceipt::find($id)->delete();
            return redirect()->route('paymentReceipt.index')
                            ->with('success','Receipt deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

}

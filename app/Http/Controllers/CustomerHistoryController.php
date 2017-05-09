<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CustomerRequest;
use App\Customer;
use App\CustomerHistory;
use App\City;
use App\State;
use App\Locality;
use App\User;
use App\Address;
use App\AddressHistory;
use Activity;
use Illuminate\Support\Facades\Auth;
class CustomerHistoryController extends Controller
{
	/**
	 *
	**/

  	public function __construct()
    {
        $this->middleware('auth');
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public $menu = 'History';

   
	public function index(Request $request)
	{
		 Activity::log('user at customer list page', Auth::id());
		if(Auth::user()->hasRole(['agent','admin' ,'owner']))
        {
	        //$customers = Customer::orderBy('id','DESC')->get();
			 $menu = $this->menu;
	        return view('pages.customerHistory.index',compact('menu'));
    	}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
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

		$custHistoryInsert = [
			'customer_id' => $request->get('customer_id'),
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name'),
			'email' => $request->get('email') , 
			'contact_no' => $request->get('contact_no') , 
			'join_date' => $request->get('join_date'),
			'alternate_no' => $request->get('alternate_no'),
			'delivery_prefer_time' => $request->get('delivery_prefer_time'),
			'introduce_by' => $request->get('introduce_by'),
			'manage_by' =>$request->get('manage_by'),
			'created_by' => $created_by,
            'updated_by' => $updated_by,
		];


        $customerHistory = CustomerHistory::create($custHistoryInsert);

        if(isset($customerHistory->id) && $customerHistory->id >0 ){

	        for($i=0; $i< count($request->get('address_line1')); $i++){
	        	$addresslineOne = $request->get('address_line1')[$i];
	        	if( isset($addresslineOne) && $addresslineOne!='' ){
		        	$custAdd = new AddressHistory;

		        	$custAdd->customer_id = $request->get('customer_id');
					$custAdd->address_line1 = $request->get('address_line1')[$i];
					$custAdd->address_line2 = $request->get('address_line2')[$i];
					$custAdd->street = $request->get('street')[$i];
					$custAdd->pin_code = $request->get('pin_code')[$i];
					$custAdd->city_id = $request->get('city_id')[$i];
					$custAdd->state_id = $request->get('state_id')[$i];
					$custAdd->locality_id = $request->get('locality_id')[$i];



		        	$customerHistory->addressHistory()->save($custAdd);
	        	}
	        }


            for($i=0; $i< count($request->get('edit_address_id')); $i++){
	         	$addr_id = $request->get('edit_address_id')[$i];

	         	if(is_array($request->get('address_delete'))){
					//$deleteArray =$request->get('address_delete');
					$deleteArray = [];
				}else{

					$deleteArray = [];
				}

	         	
	         	if(array_key_exists($addr_id, $deleteArray) ){
				//Deleting Address
	         		//Address::find($addr_id)->delete();
				}else{
				//Updating Address

					$custAdd = new AddressHistory;

		        	$custAdd->customer_id = $request->get('customer_id');
					$custAdd->address_line1 = $request->get('edit_address_line1')[$addr_id];
					$custAdd->address_line2 = $request->get('edit_address_line2')[$addr_id];
					$custAdd->street = $request->get('edit_street')[$addr_id];
					$custAdd->pin_code = $request->get('edit_pin_code')[$addr_id];
					$custAdd->city_id = $request->get('edit_city_id')[$addr_id];
					$custAdd->state_id = $request->get('edit_state_id')[$addr_id];
					$custAdd->locality_id = $request->get('edit_locality_id')[$addr_id];

					$customerHistory->addressHistory()->save($custAdd);
					
				}

	        }



            return redirect()->route('customerHistory.index')
                       ->with('success','Customer History created successfully');

    	}else{

    		return redirect()->route('customerHistory.index')
                       ->with('success','Unable to create Customer History');
    	}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		 if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_customer') ){

			$customer = Customer::find($id);
			$customerHistory =  $customer->customerHistory;
			//dd($customerHistory);
			//$user =  Customer::find($id)->user;
			 $menu = $this->menu;
	        return view('pages.customerHistory.show',compact(['customer','customerHistory','menu']));
	    }else
	    	return redirect()->route('backhome')->with("message",'You Don\'t have permission');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
	}
}

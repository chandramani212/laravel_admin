<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CustomerRequest;
use App\Customer;
use App\ContactDetail;
use App\City;
use App\State;
use App\Locality;
use App\Zone;
use App\User;
use App\Address;
use Activity;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
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
    public $menu = 'Ecommerce';

   
	public function index(Request $request)
	{
		 Activity::log('user at customer list page', Auth::id());
		if(Auth::user()->hasRole(['agent','admin' ,'owner']))
        {
	        //$customers = Customer::orderBy('id','DESC')->get();
			 $menu = $this->menu;
	        return view('pages.customers.index',compact('menu'));
    	}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('add_customer') ){
			 Activity::log('user try to add vendore or customers', Auth::id());
			$users = User::orderBy('id','ASC')->get();
			$userOption[""] = 'Choose User';
			foreach ($users as $user) {
				$userOption["$user->id"] =  $user->name ;
			}

			$cities = City::orderBy('id','ASC')->get();
			$cityOption[""] = 'Choose City';
			foreach ($cities as $city) {
				$cityOption["$city->id"] =  $city->city_name ;
			}


			$states = State::orderBy('id','ASC')->get();	
			$stateOption[""] = 'Choose State';
			foreach ($states as $state) {
				$stateOption["$state->id"] =  $state->state_name ;
			}

			$localities = Locality::orderBy('id','ASC')->get();
			$localityOption[""] = 'Choose Locality';
			foreach ($localities as $locality) {
				$localityOption["$locality->id"] =  $locality->locality_name ;
			}
			
			$zones = Zone::orderBy('id','ASC')->get();
			$zoneOption[""] = 'Choose Zone';
			foreach ($zones as $zone) {
				$zoneOption["$zone->id"] =  $zone->zone ;
			}

			 $menu = $this->menu;
			return view('pages.customers.create',compact('userOption','cityOption','stateOption','localityOption','zoneOption','menu'));
		}else
			return redirect()->route('backhome')->with("message",'You Don\'t have permission');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CustomerRequest $request)
	{
		Activity::log('user  added vendore or customers', Auth::id());
		$custInsert = [
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name'),
			'email' => $request->get('email') , 
			'contact_no' => $request->get('contact_no') , 
			'join_date' => $request->get('join_date'),
			'alternate_no' => $request->get('alternate_no'),
			'delivery_prefer_time' => $request->get('delivery_prefer_time'),
			'introduce_by' => $request->get('introduce_by'),
			'manage_by' =>$request->get('manage_by'),
			'comment' => $request->get('comment'),
			'created_by' => Auth::id(),
		];


        $customer = Customer::create($custInsert);

        if(isset($customer->id) && $customer->id >0 ){

        	### Creating History of Customer Start ###
            $request->request->add(['customer_id'=> $customer->id]);
            $request->request->add(['created_by'=> Auth::id()]);
            $customerHistory = new CustomerHistoryController;
            $customerHistory->store($request);
            ### Creating History of Customer END ###

            ### Adding Customer multiple Address Start ###
	        for($i=0; $i< count($request->get('address_line1')); $i++){
	        	$addresslineOne = $request->get('address_line1')[$i];
	        	if( isset($addresslineOne) && $addresslineOne!='' ){
		        	$custAdd = new Address;

					$custAdd->address_line1 = $request->get('address_line1')[$i];
					$custAdd->address_line2 = $request->get('address_line2')[$i];
					$custAdd->street = $request->get('street')[$i];
					$custAdd->pin_code = $request->get('pin_code')[$i];
					$custAdd->city_id = $request->get('city_id')[$i];
					$custAdd->state_id = $request->get('state_id')[$i];
					$custAdd->locality_id = $request->get('locality_id')[$i];
					$custAdd->zone_id = $request->get('zone_id')[$i];
					$custAdd->price_type = $request->get('price_type')[$i];
					$custAdd->latitude = $request->get('latitude')[$i];
					$custAdd->longitude = $request->get('longitude')[$i];



		        	$customer->address()->save($custAdd);
	        	}
	        }
	        ### Adding Customer multiple Address End ###


	        ### Adding Customer Mulitple Other Contact Details Start ###
	        for($i=0; $i< count($request->get('other_contact_first_name')); $i++){
	        	$otherContactFirstName = $request->get('other_contact_first_name')[$i];
	        	if( isset($otherContactFirstName) && $otherContactFirstName!='' ){
		        	$contactDetail = new ContactDetail;

					$contactDetail->first_name = $request->get('other_contact_first_name')[$i];
					$contactDetail->last_name = $request->get('other_contact_last_name')[$i];
					$contactDetail->contact_no = $request->get('other_contact_no')[$i];
					$contactDetail->alternate_no = $request->get('other_alternate_no')[$i];
					$contactDetail->email = $request->get('other_email')[$i];
					$contactDetail->default = $request->get('default_contact')[$i];

		        	$customer->contactDetails()->save($contactDetail);
	        	}
	        }
	        ### Adding Customer Multiple Other Contact Details End ###

	        return redirect()->route('customer.index')
	                       ->with('success','Customer created successfully');
        }else{

    		return redirect()->route('customer.index')
                       ->with('success','Unable to create Customer');

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
		 Activity::log('user  vendore or customers view page', Auth::id());
		 if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_customer') ){
			$customer= Customer::find($id);
			if($customer){

				$address =  Customer::find($id)->address;
				$contactDetails =  Customer::find($id)->contactDetails;
				//dd($address);
				//$user =  Customer::find($id)->user;
				$menu = $this->menu;
		        return view('pages.customers.show',compact(['customer','address','contactDetails','menu']));
	    	}else{

	    		return redirect()->route('customer.index')->with("message",'Customer Not Exists');
	    	}
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
		Activity::log('user try to edit vendore/customers info', Auth::id());
		if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_customer') ){
			$customer= Customer::find($id);
			$address =  Customer::find($id)->address;
			$contactDetails =  Customer::find($id)->contactDetails;
			$introduceUser =  Customer::find($id)->introduceUser;
			$manageUser =  Customer::find($id)->manageUser;
			$users = User::orderBy('id','ASC')->get();
			$userOption[""] = 'Choose User';
			foreach ($users as $user) {
				$userOption["$user->id"] =  $user->name ;
			};

			$cities = City::orderBy('id','ASC')->get();
			$cityOption[""] = 'Choose City';
			foreach ($cities as $city) {
				$cityOption["$city->id"] =  $city->city_name ;
			}


			$states = State::orderBy('id','ASC')->get();	
			$stateOption[""] = 'Choose State';
			foreach ($states as $state) {
				$stateOption["$state->id"] =  $state->state_name ;
			}

			$localities = Locality::orderBy('id','ASC')->get();
			$localityOption[""] = 'Choose Locality';
			foreach ($localities as $locality) {
				$localityOption["$locality->id"] =  $locality->locality_name ;
			}
			
			$zones = Zone::orderBy('id','ASC')->get();
			$zoneOption[""] = 'Choose Zone';
			foreach ($zones as $zone) {
				$zoneOption["$zone->id"] =  $zone->zone ;
			}

	 		$menu = $this->menu;
	        return view('pages.customers.edit',compact(['customer','userOption','introduceUser','manageUser','cityOption','stateOption','localityOption','address','contactDetails','zoneOption','menu']));
	    }else
	    	return redirect()->route('backhome')->with("message",'You Don\'t have permission');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		Activity::log('updated vendore/customers info', Auth::id());
		 $this->validate($request, [
            'first_name' => 'required',
        ]);

		// dd($request);

		$custUpdate = [
			'first_name' => $request->get('first_name'),
			'last_name' => $request->get('last_name'),
			'email' => $request->get('email') , 
			'contact_no' => $request->get('contact_no') , 
			'join_date' => $request->get('join_date'),
			'alternate_no' => $request->get('alternate_no'),
			'delivery_prefer_time' => $request->get('delivery_prefer_time'),
			'introduce_by' => $request->get('introduce_by'),
			'comment' => $request->get('comment'),
			'manage_by' =>$request->get('manage_by')
			
		];

        $customerUpdate =   Customer::find($id)->update($custUpdate);

        if($customerUpdate){

	    	### Creating History of Customer Start ###
	        $request->request->add(['customer_id'=> $id]);
	        $request->request->add(['updated_by'=> Auth::id()]);
	        $customerHistory = new CustomerHistoryController;
	        $customerHistory->store($request);
	        ### Creating History of Customer END ###
			
			### Editing Customer Address Start ###
	        for($i=0; $i< count($request->get('edit_address_id')); $i++){
	         	$addr_id = $request->get('edit_address_id')[$i];

				if(is_array($request->get('address_delete'))){
					$deleteArray =$request->get('address_delete');
				}else{

					$deleteArray = [];
				}
	         	
	         	if(array_key_exists($addr_id, $deleteArray) ){
				//Deleting Address
	         		Address::find($addr_id)->delete();
				}else{
				//Updating Address
					
					$custAddUpdate = [
						'address_line1' => $request->get('edit_address_line1')[$addr_id],
						'address_line2' => $request->get('edit_address_line2')[$addr_id],
						'street' => $request->get('edit_street')[$addr_id] , 
						'pin_code' => $request->get('edit_pin_code')[$addr_id], 
						'city_id' => $request->get('edit_city_id')[$addr_id],
						'state_id' => $request->get('edit_state_id')[$addr_id],
						'locality_id' => $request->get('edit_locality_id')[$addr_id],
						'zone_id'  => $request->get('edit_zone_id')[$addr_id],
						'price_type'  => $request->get('edit_price_type')[$addr_id],
						'latitude'  => $request->get('edit_latitude')[$addr_id],
						'longitude'  => $request->get('edit_longitude')[$addr_id],
					];

					Address::find($addr_id)->update($custAddUpdate);
				}

	        }
	        ### Editing Customer Address End ###

	        ### Adding Customer Address Start ###
	        $customer = Customer::find($id);
	        for($i=0; $i< count($request->get('address_line1')); $i++){
	       		$addresslineOne = $request->get('address_line1')[$i];
	       		if( isset($addresslineOne) && $addresslineOne!='' ){

		        	$custAdd = new Address;

					$custAdd->address_line1 = $addresslineOne;
					$custAdd->address_line2 = $request->get('address_line2')[$i];
					$custAdd->street = $request->get('street')[$i];
					$custAdd->pin_code = $request->get('pin_code')[$i];
					$custAdd->city_id = $request->get('city_id')[$i];
					$custAdd->state_id = $request->get('state_id')[$i];
					$custAdd->locality_id = $request->get('locality_id')[$i];
					$custAdd->zone_id = $request->get('zone_id')[$i];
					$custAdd->price_type = $request->get('price_type')[$i];
					$custAdd->latitude = $request->get('latitude')[$i];
					$custAdd->longitude = $request->get('longitude')[$i];
					//dd($custAdd);
		        	$customer->address()->save($custAdd);
	        	}
	        }
	        ### Adding Customer Address Ends ###


	        ### Editing Customer Contact Details Start ###
	        for($i=0; $i< count($request->get('edit_contact_details_id')); $i++){
	         	$contactDetailId = $request->get('edit_contact_details_id')[$i];

				if(is_array($request->get('contact_details_delete'))){
					$deleteArray =$request->get('contact_details_delete');
				}else{

					$deleteArray = [];
				}
	         	
	         	if(array_key_exists($contactDetailId, $deleteArray) ){
				//Deleting Address
	         		ContactDetail::find($contactDetailId)->delete();
				}else{
				//Updating Address
					
					$contDetailUpdate = [
						'first_name' => $request->get('edit_other_contact_first_name')[$contactDetailId],
						'last_name' => $request->get('edit_other_contact_last_name')[$contactDetailId],
						'contact_no' => $request->get('edit_other_contact_no')[$contactDetailId] , 
						'alternate_no' => $request->get('edit_other_alternate_no')[$contactDetailId], 
						'email' => $request->get('edit_other_email')[$contactDetailId],
						'default' => $request->get('edit_default_contact')[$contactDetailId]		
					];

					ContactDetail::find($contactDetailId)->update($contDetailUpdate);
				}

	        }
	        ### Editing Customer Contact Details Start ###


	       	### Adding Customer Contact Details Start ###
	        $customer = Customer::find($id);
	        for($i=0; $i< count($request->get('other_contact_first_name')); $i++){
	        	$otherContactFirstName = $request->get('other_contact_first_name')[$i];
	        	if( isset($otherContactFirstName) && $otherContactFirstName!='' ){
		        	$contactDetail = new ContactDetail;

					$contactDetail->first_name = $request->get('other_contact_first_name')[$i];
					$contactDetail->last_name = $request->get('other_contact_last_name')[$i];
					$contactDetail->contact_no = $request->get('other_contact_no')[$i];
					$contactDetail->alternate_no = $request->get('other_alternate_no')[$i];
					$contactDetail->email = $request->get('other_email')[$i];
					$contactDetail->default = $request->get('default_contact')[$i];

		        	$customer->contactDetails()->save($contactDetail);
	        	}
	        }
	        ### Adding Customer Contact Details Ends ###

    	}


        return redirect()->route('customer.index')
                        ->with('success','Customer updated successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Activity::log('user try to delete vendore/customers info', Auth::id());
		if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_customer') ){
			Customer::find($id)->delete();
	        return redirect()->route('customer.index')
                        ->with('success','Customer deleted successfully');
        }else
        	return redirect()->route('backhome')->with("message",'You Don\'t have permission');
	}
}

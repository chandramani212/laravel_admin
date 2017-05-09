<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\LocalityRequest;
use App\State;
use App\City;
use App\Locality;
use App\User;
use Activity;
use Illuminate\Support\Facades\Auth;

class LocalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Place';
    public function index()
    {
        Activity::log('user at Localiy list page', Auth::id());
        if(Auth::user()->hasRole(['agent', 'admin', 'owner']))
        {
            //$customers = Customer::orderBy('id','DESC')->get();
            $menu = $this->menu;
            $states = State::get(); 
            $cities = City::get(); 
            return view('pages.locality.index',compact('states','cities','menu'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('add_customer') ){

            Activity::log('user try to add Locality', Auth::id());

            $states = State::get();
            $cities = City::get();
            

             $menu = $this->menu;
            return view('pages.locality.create',compact('states','cities','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocalityRequest $request)
    {
        Activity::log('user  added Locality', Auth::id());

        $localityInsert = [
            'created_by' => $request->get('created_by'),
            'status' => $request->get('status'),
            'city_id' => $request->get('city_id'),
            'locality_name' => $request->get('locality_name'),
        ];

        $locality = Locality::create($localityInsert);

        if(isset($locality->id) && $locality->id > 0)
        {
            return redirect()->route('locality.index')
                           ->with('success','locality created successfully');
        }else{

            return redirect()->route('locality.index')
                       ->with('success','Unable to create locality');
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
        Activity::log('user  Locality view page', Auth::id());
         if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_customer') ){
            $locality= Locality::find($id);

             $menu = $this->menu;
            return view('pages.locality.show',compact(['locality','menu']));
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
        Activity::log('user try to edit Locality info', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_customer') ){
            $locality= Locality::find($id);
            $states = State::get();
            $cities = City::get();


            $menu = $this->menu;
            return view('pages.locality.edit',compact(['locality','states','cities','menu']));
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
        Activity::log('updated Locality info', Auth::id());
         $this->validate($request, [
            'locality_name' => 'required',
        ]);

        // dd($request);

        $localityUpdate = [
            'updated_by' => $request->get('updated_by'),
            'status' => $request->get('status'),
            'city_id' => $request->get('city_id'),
            'locality_name' => $request->get('locality_name'),
        ];

        $localityUpdate =   Locality::find($id)->update($localityUpdate);

        return redirect()->route('locality.index')
                           ->with('success','locality Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Activity::log('user try to delete Locality info', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_customer') ){
            Locality::find($id)->delete();
            return redirect()->route('locality.index')
                        ->with('success','Locality deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }
}

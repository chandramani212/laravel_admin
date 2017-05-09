<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CityRequest;
use App\State;
use App\City;
use App\User;
use Activity;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Place';
    public function index()
    {
        Activity::log('user at City list page', Auth::id());
        if(Auth::user()->hasRole(['agent', 'admin', 'owner']))
        {
            //$customers = Customer::orderBy('id','DESC')->get();
            $menu = $this->menu;
            $states = State::get(); 

            //dd($states);
            return view('pages.city.index',compact('states','menu'));
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

            Activity::log('user try to add City', Auth::id());

            $states = State::get();
            

             $menu = $this->menu;
            return view('pages.city.create',compact('states','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        Activity::log('user  added City', Auth::id());
        $city = City::create($request->all());
        if(isset($city->id) && $city->id > 0)
        {
            return redirect()->route('city.index')
                           ->with('success','City created successfully');
        }else{

            return redirect()->route('city.index')
                       ->with('success','Unable to create city');
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
        Activity::log('user  City view page', Auth::id());
         if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_customer') ){
            $city= City::find($id);

             $menu = $this->menu;
            return view('pages.city.show',compact(['city','menu']));
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
        Activity::log('user try to edit City info', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_customer') ){
            $city= City::find($id);
            $states = State::get();


            $menu = $this->menu;
            return view('pages.city.edit',compact(['city','states','menu']));
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
        Activity::log('updated City info', Auth::id());
         $this->validate($request, [
            'city_name' => 'required',
        ]);

        $cityUpdate = City::find($id)->update($request->all());
    

        return redirect()->route('city.index')
                           ->with('success','City Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Activity::log('user try to delete City info', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_customer') ){
            City::find($id)->delete();
            return redirect()->route('city.index')
                        ->with('success','City deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }
}

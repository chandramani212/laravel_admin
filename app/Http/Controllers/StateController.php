<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StateRequest;
use App\State;
use App\User;
use Activity;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Place';

    public function index()
    {
        Activity::log('user at State list page', Auth::id());
        if(Auth::user()->hasRole(['agent', 'admin', 'owner']))
        {
            //$customers = Customer::orderBy('id','DESC')->get();
            $menu = $this->menu;
            return view('pages.state.index',compact('menu'));
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
             Activity::log('user try to add state', Auth::id());
           

            $menu = $this->menu;
            return view('pages.state.create',compact('menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        //
        Activity::log('user  added state', Auth::id());
        $state = State::create($request->all());
        if(isset($state->id) && $state->id > 0)
        {
            return redirect()->route('state.index')
                           ->with('success','State created successfully');
        }else{

            return redirect()->route('state.index')
                       ->with('success','Unable to create State');
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
        Activity::log('user  State view page', Auth::id());
         if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('show_customer') ){
            $state= State::find($id);

             $menu = $this->menu;
            return view('pages.state.show',compact(['state','menu']));
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
        Activity::log('user try to State City edit', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_customer') ){
            $state= State::find($id);
        


            $menu = $this->menu;
            return view('pages.state.edit',compact(['state','menu']));
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
        Activity::log('updated State info', Auth::id());
         $this->validate($request, [
            'state_name' => 'required',
        ]);

        $stateUpdate = State::find($id)->update($request->all());
    

        return redirect()->route('state.index')
                           ->with('success','State Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Activity::log('user try to delete state info', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_customer') ){
            State::find($id)->delete();
            return redirect()->route('state.index')
                        ->with('success','State deleted successfully');
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }
}

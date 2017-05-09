<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\State;
use DB;

class StateGeneralController extends Controller
{
    public function postState(Request $request){


		$query = DB::table('state')
				// ->join('customers','orders.customer_id','=','customers.id')
				 ->select('state.id','state.state_name');

		if($request->has('state_id')){
			
			$query->where('state.id','=',$request->get('state_id'));
		}
		if($request->has('state_name')){

			$query->where('state.state_name','like','%'.$request->get('state_name').'%');
		}
		
		$query->orderBy('state.id','desc');

		$states = $query->get();
		
		$iTotalRecords = count($states);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$state = $states[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $state->id,
		  $state->state_name,
		  '<a href="'.route('state.show',$state->id).'" class="btn btn-xs default">View</a>
		   <a href="'.route('state.edit',$state->id).'" class="btn btn-xs green">Edit</a> 
		   <form style="float:right" action="'.route('state.destroy',$state->id).'" method="post" >
		   <input type="hidden" name="_method" value="DELETE" />
		   <input type="hidden" name="_token" value="'.csrf_token().'" />
		   <input type="submit" class="btn btn-xs red" value="Delete">
		   </form>
		   ',
		);
		}

		if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
		$records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
		$records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
		
	}
}

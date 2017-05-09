<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\State;
use App\City;
use App\Locality;
use DB;

class LocalityGeneralController extends Controller
{
    public function postLocality(Request $request){


		$query = DB::table('locality')
				 ->join('city','locality.city_id','=','city.id')
				 ->join('state','city.state_id','=','state.id')
				 ->select('locality.id','locality.locality_name','city.city_name','state.state_name');

		if($request->has('locality_id')){
			
			$query->where('locality.id','=',$request->get('locality_id'));
		}
		if($request->has('city_id')){
			
			$query->where('city.id','=',$request->get('city_id'));
		}
		if($request->has('state_id')){
			
			$query->where('state.id','=',$request->get('state_id'));
		}
		if($request->has('locality_name')){

			$query->where('locality.locality_name','like','%'.$request->get('locality_name').'%');
		}
		
		$query->orderBy('city.id','desc');

		$localities = $query->get();
		
		$iTotalRecords = count($localities);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$locality = $localities[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $locality->id,
		  $locality->locality_name,
		  $locality->city_name,
		  $locality->state_name,
		  '<a href="'.route('locality.show',$locality->id).'" class="btn btn-xs default">View</a>
		   <a href="'.route('locality.edit',$locality->id).'" class="btn btn-xs green">Edit</a> 
		   <form style="float:right" action="'.route('locality.destroy',$locality->id).'" method="post" >
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

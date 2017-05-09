<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\State;
use App\City;
use DB;

class CityGeneralController extends Controller
{
    public function postCity(Request $request){


		$query = DB::table('city')
				 ->join('state','city.state_id','=','state.id')
				 ->select('city.id','city.city_name','state.state_name');

		if($request->has('city_id')){
			
			$query->where('city.id','=',$request->get('city_id'));
		}
		if($request->has('state_id')){
			
			$query->where('state.id','=',$request->get('state_id'));
		}
		if($request->has('city_name')){

			$query->where('city.city_name','like','%'.$request->get('city_name').'%');
		}
		
		$query->orderBy('city.id','desc');

		$cities = $query->get();
		
		$iTotalRecords = count($cities);
		$iDisplayLength = intval($request->get('length'));
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart = intval($request->get('start'));
		$sEcho = intval($request->get('draw'));

		$records = array();
		$records["data"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;
		$end = $end > $iTotalRecords ? $iTotalRecords : $end;

		for($i = $iDisplayStart; $i < $end; $i++) {
			$city = $cities[$i];
		//$status = $status_list[rand(0, 2)];
		$id = ($i + 1);

		$records["data"][] = array(
		  '<input type="checkbox" name="id[]" value="'.$id.'">',
		  $city->id,
		  $city->city_name,
		  $city->state_name,
		  '<a href="'.route('city.show',$city->id).'" class="btn btn-xs default">View</a>
		   <a href="'.route('city.edit',$city->id).'" class="btn btn-xs green">Edit</a> 
		   <form style="float:right" action="'.route('city.destroy',$city->id).'" method="post" >
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\product;
use App\User;
use App\category;
use DB;

class gerneralController extends Controller {
    /* This function use for display all the product in grid view uising ajax call
     */

    public $menu = 'Product';

    public function allProduct() {
        //print_r($_POST);

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

        $product_name = isset($_REQUEST['product_name']) ? $_REQUEST['product_name'] : '';
        $created_from = isset($_REQUEST['created_from']) ? $_REQUEST['created_from'] : '';
        $created_to = isset($_REQUEST['created_to']) ? $_REQUEST['created_to'] : '';
        $updated_from = isset($_REQUEST['updated_from']) ? $_REQUEST['updated_from'] : '';
        $category_id = isset($_REQUEST['category_name']) ? $_REQUEST['category_name'] : '';

        $updated_to = isset($_REQUEST['updated_to']) ? $_REQUEST['updated_to'] : '';
        if (!empty($category_id)) {
            $product = DB::table('products as P')
                    ->where('C.id', '=', $category_id)
                    ->where('P.status', '=', 1)
                    ->join('categories as C', 'C.id', '=', 'P.category_id')
                    ->select('P.id', 'P.product_name', 'P.updated_at', 'P.status', 'C.category_name')
                    ->orderBy('P.id', 'asc')
                    ->get();
        } else if (!empty($updated_from) && !empty($updated_to)) {

            $start = date('Y-d-m', strtotime($updated_from));

            $date = str_replace('/', '-', $updated_to);

            $end = date('Y-d-m', strtotime($date));
//    		$products = product::where('status', 1)
//				   	->whereBetween('updated_at',[$start,$end])
//               	   ->orderBy('id', 'asc')
//               	   ->get();

            $product = DB::table('products as P')
                    ->whereBetween('P.updated_at', [$start, $end])
                    ->where('P.status', '=', 1)
                    ->join('categories as C', 'C.id', '=', 'P.category_id')
                    ->select('P.id', 'P.product_name', 'P.updated_at', 'P.status', 'C.category_name')
                    ->orderBy('P.id', 'asc')
                    ->get();
            // dd($product);   
        } elseif (!empty($created_from) && !empty($created_to)) {
            $start = date('Y-d-m', strtotime($created_from));
            $end = date('Y-d-m', strtotime($created_to));
            //echo $created_from;
//    		$products = product::where('status', 1)
//				   	->whereBetween('created_at',[$start,$end])
//               	   ->orderBy('id', 'asc')
//               	   ->get();
        } elseif (!empty($product_name)) {
//            $products = product::where('status', 1)
//                    ->where('product_name', 'like', $product_name . '%')
//                    ->orderBy('id', 'asc')
//                    ->get();
            //  echo $product_name;
            $product = DB::table('products as P')
                    ->where('P.product_name', 'like', $product_name . '%')
                    ->where('P.status', '=', 1)
                    ->join('categories as C', 'C.id', '=', 'P.category_id')
                    ->select('P.id', 'P.product_name', 'P.updated_at', 'P.status', 'C.category_name')
                    ->orderBy('P.id', 'asc')
                    ->get();
        } elseif (!empty($id)) {
//            $products = product::where('status', 1)
//                    ->where('id', $id)
//                    ->orderBy('id', 'asc')
//                    ->get();
            $product = DB::table('products as P')
                    ->where('P.id', '=', $id)
                    ->where('P.status', '=', 1)
                    ->join('categories as C', 'C.id', '=', 'P.category_id')
                    ->select('P.id', 'P.product_name', 'P.updated_at', 'P.status', 'C.category_name')
                    ->orderBy('P.id', 'asc')
                    ->get();
        } else {
//	 	$products = product::where('status', 1)
//	        	   ->orderBy('id', 'asc')
//               	   ->get();
            $product = DB::table('products as P')
                    ->where('P.status', '=', '1')
                    ->join('categories as C', 'C.id', '=', 'P.category_id')
                    ->select('P.id', 'P.product_name', 'P.updated_at', 'P.status', 'C.category_name')
                    ->get();
        }


//dd($products);
        $iTotalRecords = sizeof($product);
        //$iTotalRecords = $products->count();
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $status_list = array(
            array("success" => "Pending"),
            array("info" => "Closed"),
            array("danger" => "On Hold"),
            array("warning" => "Fraud")
        );

        /* foreach ($products as $product) {
          $status = $status_list[rand(0, 2)];
          $id= $product->id;
          $records["data"][] = array(
          '<input type="checkbox" name="id[]" value="'.$id.'">',
          $id,
          $product->product_name,
          date($product->created_at),
          date($product->updated_at),
          ($product-> status)?"Active":"De-active",
          '<a href="product/'.$id.'" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> Delete</a>

          <a href="product/'.$id.'/edit" class="btn default btn-xs purple">
          <i class="fa fa-edit"></i> Edit </a>
          ',
          );
          }
         */
        //$product = $products->toArray();
        //	print_r($product);exit;
        $product = json_decode(json_encode($product), True);
        //  print_r($product);exit;
        for ($i = $iDisplayStart; $i < $end; $i++) {
            $status = $status_list[rand(0, 2)];
            $id = $product[$i]['id'];
            $records["data"][] = array(
                '<input type="checkbox" name="id[]" value="' . $id . '">',
                $id,
                $product[$i]['product_name'],
                $product[$i]['category_name'],
                //date($product[$i]['created_at']),
                date($product[$i]['updated_at']),
                ($product[$i]['status']) ? "Active" : "De-active",
                '<a href="product/' . $id . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> Delete</a>

		      	  <a href="product/' . $id . '/edit" class="btn default btn-xs purple">
										<i class="fa fa-edit"></i> Edit </a>
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

    public function attributePriceHistory($attributeId) {

        $menu = $this->menu;
        return view('products.attributePriceHistory', compact('attributeId', 'menu'));
    }

    public function procurement_details() {

        $user_name = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';

        $created_from = isset($_REQUEST['created_from']) ? $_REQUEST['created_from'] : '';
        $created_to = isset($_REQUEST['created_to']) ? $_REQUEST['created_to'] : '';
        $updated_from = isset($_REQUEST['updated_from']) ? $_REQUEST['updated_from'] : '';
        $updated_to = isset($_REQUEST['updated_to']) ? $_REQUEST['updated_to'] : '';
        $flag = false;
        if (!empty($updated_from) && !empty($updated_to)) {
            $start = date('Y-d-m', strtotime($updated_from));
            $end = date('Y-d-m', strtotime($updated_to));
            $procurements = DB::table('users')
                    ->join('procurements', 'users.id', '=', 'procurements.agent_id')
                    ->whereBetween('procurements.created_at', [$start, $end])
                    ->select('users.name', 'procurements.*')
                    ->get();
            $itemCount = sizeof($procurements);
            $flag = true;
        } elseif (!empty($created_from) && !empty($created_to)) {
            $start = date('Y-d-m', strtotime($created_from));
            $end = date('Y-d-m', strtotime($created_to));
            /*  $procurements = user::with('procurement')
              ->whereBetween('procurement.created_at',[$start,$end])
              ->orderBy('id','desc')
              ->toSql();//toSql() */
            $procurements = DB::table('users')
                    ->join('procurements', 'users.id', '=', 'procurements.agent_id')
                    ->whereBetween('procurements.created_at', [$start, $end])
                    ->select('users.name', 'procurements.*')
                    ->get();
            $itemCount = sizeof($procurements);
            $flag = true;
        } elseif (!empty($user_name)) {
            $procurements = user::where('name', 'like', '%' . $user_name . '%')->with('procurement')->orderBy('id', 'desc')->get();
            $itemCount = $procurements->first()->procurement->count();
        } else {
            $procurements = user::with('procurement')->orderBy('id', 'desc')->get(
            );
            $itemCount = $procurements->first()->procurement->count();
        }

        //echo  $procurements->procurement->count();

        $status_list = array(
            array("success" => "Pending"),
            array("info" => "Closed"),
            array("danger" => "On Hold"),
            array("warning" => "Fraud")
        );
        $records = array();
        $records["data"] = array();

        if (!$flag) {

            foreach ($procurements as $procurementsvalue) {
                $id = $procurementsvalue->id;
                $name = $procurementsvalue->name;

                //  $itemCount = $procurementsvalue->procurement()->count();
                foreach ($procurementsvalue->procurement as $values) {

                    $values->id;
                    $records["data"][] = array(
                        '<input type="checkbox" name="id[]" value="1">',
                        $values->id,
                        $name,
                        $values->total_budget,
                        date($values->created_at),
                        date($values->updated_at),
                        '<a href="procurement/' . $values->id . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> View</a>

		      	  <a href="procurement/' . $values->id . '/edit" class="btn default btn-xs purple">
										<i class="fa fa-edit"></i> Edit </a>
		      	 ',
                    );
                }
            }
        } else {
            foreach ($procurements as $procurement) {
                $procurement->id;
                $records["data"][] = array(
                    '<input type="checkbox" name="id[]" value="1">',
                    $procurement->id,
                    $procurement->name,
                    $procurement->total_budget,
                    date($procurement->created_at),
                    date($procurement->updated_at),
                    '<a href="procurement/' . $procurement->id . '" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> View</a>

		      	  <a href="procurement/' . $procurement->id . '/edit" class="btn default btn-xs purple">
										<i class="fa fa-edit"></i> Edit </a>
		      	 ',
                );
            }
        }
        $iTotalRecords = $itemCount; // ->count();

        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);



        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;



        foreach ($procurements as $procurement) {
            
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

    public function categorylist() {

        $categories = DB::table('categories')->get();

        $iTotalRecords = category::count(); //$categories->count();
        $categories = json_decode(json_encode($categories), true);
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $status_list = array(
            array("success" => "Pending"),
            array("info" => "Closed"),
            array("danger" => "On Hold"),
            array("warning" => "Fraud")
        );

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $status = $status_list[rand(0, 2)];
            $id = $categories[$i]['id'];
            $records["data"][] = array(
                '<input type="checkbox" name="id[]" value="' . $id . '">',
                $id,
                $categories[$i]['category_name'],
                $categories[$i]['created_at'],
                $categories[$i]['updated_at'],
                $categories[$i]['status'],
                '<a href="category/' . $id . '/edit" class="btn btn-xs default btn-editable"><i class="fa fa-search"></i> Edit</a>
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
    
    /*
     * this function use for change the restorent zone on the flag after the submit
     */
    public function zoneupdate(Request $request)
    {
        echo "HEllo";
        $formdata = $_POST['formdata'];
		print_r($formdata);
        echo sizeof($formdata);
		for($i=0;$i<sizeof($formdata);$i++)
		{
			$zone_id = $formdata[$i]['name'];
			$zone_id = $this->GetBetween("[","]",$zone_id);
			$restorent_ids = json_decode($formdata[$i]['value'],true);
			$restorent_ids = $this->array_flatten($restorent_ids);
//			print_r($this->array_flatten($restorent_ids));
			DB::table('address')->whereIn('customer_id', $restorent_ids)->update(['zone_id' => $zone_id]);
		}
		//print_r($_POST);
       // dd($request);
    }
	public	function GetBetween($var1="",$var2="",$pool){
			$temp1 = strpos($pool,$var1)+strlen($var1);
			$result = substr($pool,$temp1,strlen($pool));
			$dd=strpos($result,$var2);
			if($dd == 0){
			$dd = strlen($result);
			}
			
			return substr($result,0,$dd);
	}
	
public	function array_flatten($array) { 
		  if (!is_array($array)) { 
			return FALSE; 
		  } 
		  $result = array(); 
		  foreach ($array as $key => $value) { 
			if (is_array($value)) { 
			  $result = array_merge($result, array_flatten($value)); 
			} 
			else { 
			  $result[$key] = $value; 
			} 
		  } 
		  return $result; 
	} 
}

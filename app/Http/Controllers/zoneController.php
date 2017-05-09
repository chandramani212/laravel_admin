<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class zoneController extends Controller {

    /**
     * Show all zone wise restourents
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //  echo "Show all zone wise restourents";
        $zone_list = DB::table('zones')
                ->where('status', '=', '1')
                ->select('id', 'zone')
                ->get();

        //customer list and addrees
        $merchant_list = DB::table('address as A')
                ->join('customers as C', 'C.id', '=', 'A.customer_id')
                ->select('C.id','C.first_name', 'C.last_name', 'A.address_line1', 'A.street', 'A.zone_id')
                ->orderBy('A.zone_id')
                ->get();
        $merchant_list = collect($merchant_list);
//     // print_r($merchant_list);
//        $collection = collect([
//            ['product' => 'Desk', 'price' => 200],
//            ['product' => 'Chair', 'price' => 100],
//            ['product' => 'Bookcase', 'price' => 150],
//            ['product' => 'Door', 'price' => 100],
//        ]);
////print_r($collection);
//echo "Out put below";
        //$filtered = $merchant_list->where('zone_id', 1);

       // $filtered->all();
     //   dd($filtered->all());
        return view('zone.allzone', compact('zone_list','merchant_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('zone.addzone');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $zone_name = $request->get('zone_name');
        DB::table('zones')->insert(
                ['zone' => $zone_name]
        );
        return redirect()->route('zone.create')->with("message", 'Item has added succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}

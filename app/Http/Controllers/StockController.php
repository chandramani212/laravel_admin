<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StockRequest;
use App\Stock;
use App\StockWastage;
use App\StockHistory;
use App\product as Product;
use App\product_attribute as ProductAttribute;

use Activity;
use Illuminate\Support\Facades\Auth;
class StockController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Ecommerce';
    public function index()
    {
         Activity::log('user at stock list page', Auth::id());
         if(Auth::user()->hasRole(['agent','admin' ,'woner']))
        { 
            $menu = $this->menu;
            return view('pages.stocks.index',compact('menu'));
        }else
        {
            return redirect()->route('backhome')->with("message",'You Don\'t have permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         Activity::log('user try to stock ', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('create_stock') ){
            $menu = $this->menu;
            return view('pages.stocks.create',compact('menu'));
        }else
             return redirect()->route('backhome')->with("message",'You Don\'t have permission');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        //dd($request);

        //This is used to update stock if it already exists START
        $stock = Stock::where('product_id','=',$request->get('product_id'))
                        ->where('attribute_id','=',$request->get('attribute_id'))->get()->first();


        if(isset($stock->id)){
          
           $request->merge(array('exists_total_qty_in_hand' => $stock->total_qty_in_hand));
          
            $this->update($request,$stock->id);
             return redirect()->route('stock.index')
                        ->with('success','Stock updated successfully');
        } 
        //This is used to update stock if it already exists END

        $stockInsert = [
            //'order_by' => $request->get('last_name'),
            'total_qty_in_hand' => $request->get('total_qty_in_hand'),
            'product_id' => $request->get('product_id'),
            'attribute_id' => $request->get('attribute_id'),
			'added_by' => Auth::id(),
        ];


        $stock = Stock::create($stockInsert);

        for($i=0;$i<count($request->get('basic_qty'));$i++){
            $basic_qty = $request->get('basic_qty')[$i];

            if( isset($basic_qty) && $basic_qty!='' ){
                $stockWastage =  new StockWastage;

                $stockWastage->basic_qty = $basic_qty;
                $stockWastage->reason = $request->get('reason')[$i];
                $stockWastage->added_by =  Auth::id();

                $stock->wastages()->save($stockWastage);

            }
        }

          Activity::log('stock added successfully', Auth::id());
        return redirect()->route('stock.index')
                       ->with('success','Stock Added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Activity::log('user view stock of product', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('view_stock') ){
            $stock = Stock::find($id);
            $wastages = Stock::find($id)->wastages;

            $menu = $this->menu;
            return view('pages.stocks.show',compact('stock','wastages','menu'));
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

        Activity::log('user Edit stock of product', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('edit_stock') ){
            $stock = Stock::find($id);
            $wastages = Stock::find($id)->wastages;
            $menu = $this->menu;
            return view('pages.stocks.edit',compact('stock','wastages','menu'));
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
         Activity::log('user update stock of product successfully', Auth::id());
        $this->validate($request, [
            'product_id' => 'required',
            'attribute_id' => 'required',
        ]);

        $exists_qty = (null!==$request->get('exists_total_qty_in_hand'))?$request->get('exists_total_qty_in_hand'):0;

        $stockUpdate = [
            'total_qty_in_hand' => $request->get('total_qty_in_hand') +  $exists_qty,
            'product_id' => $request->get('product_id'),
            'attribute_id' => $request->get('attribute_id'),
			'updated_by' => Auth::id(),
   
        ];
		
		$stockHistoryInsert = [
            //'order_by' => $request->get('last_name'),
            'basic_qty' =>  $request->get('total_qty_in_hand'),
            //'basic_mrp' => $stock->product_id,
            'stock_id' => $id,
            'updated_by' =>  Auth::id(),
        ];


        if(Stock::find($id)->update($stockUpdate)){

			
			 StockHistory::create($stockHistoryInsert );

			for($i=0; $i< count($request->get('edit_stock_wastage_id')); $i++){
				$stockWastage_id = $request->get('edit_stock_wastage_id')[$i];
				$delete_status = isset($request->get('delete_stock_wastage')[$i])?$request->get('delete_stock_wastage')[$i]:'False';

				
				if($delete_status == 'True'){
				//DELETING  DETAILS
					StockWastage::find($stockWastage_id)->delete();
				}else{
				//UPDATING  DETAILS
					$stockWastageUpdate = [

					'basic_qty'=> $request->get('edit_basic_qty')[$i],
					'reason'=> $request->get('edit_reason')[$i],
                    'updated_by'=> Auth::id(),
				  
					];

					StockWastage::find($stockWastage_id)->update($stockWastageUpdate);
				}

			}


			$stock = Stock::find($id);
			for($i=0;$i<count($request->get('basic_qty'));$i++){
				$basic_qty = $request->get('basic_qty')[$i];

				if( isset($basic_qty) && $basic_qty!='' ){
					$stockWastage =  new StockWastage;

					$stockWastage->basic_qty = $basic_qty;
					$stockWastage->reason = $request->get('reason')[$i];

					$stock->wastages()->save($stockWastage);

				}
			}

		}
        return redirect()->route('stock.index')
                        ->with('success','Stock updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Activity::log('user Delete stock of product', Auth::id());
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('owner') || Auth::user()->can('delete_stock') ){
            Stock::find($id)->delete();
            return redirect()->route('stock.index')
                        ->with('success','Stock deleted successfully');
        }
    }
}

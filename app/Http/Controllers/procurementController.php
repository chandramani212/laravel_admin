<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\procurementRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\product_arttributeRequest;
use App\Http\Requests\ProcurementDetailsRequest;
use App\Http\Requests\procurement_expenseRequest;
use App\procurement;
use App\User;
use App\product_attribute;
use App\procurement_detail;
use App\product;
use App\procurement_expense;
use Activity;
use Illuminate\Support\Facades\Auth;
use DB;
class procurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $menu = 'Product';
     public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
         if(Auth::user()->hasRole('admin')|| Auth::user()->hasRole('owner') || Auth::user()->hasRole('agnet') ){
              Activity::log('user at procurement list page', Auth::id());
               $menu = $this->menu;
                return view('procurement.procurementDetails',compact('menu'));
            }else
                return redirect()->route('backhome')->with("message",'You Don\'t have permission ');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // echo "VIJAY" ; exit;
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('owner') ||  Auth::user()->can('add_procuremnet')){
               Activity::log('user at  create procurement ', Auth::id());
              
                $users = User::where('status', '=', '1')
                    ->select('id', 'name')
                    ->get() ;
                
               
                
                $products = product::where('status','=','1')->select('id','product_name')->get();
                            
                $product_attribute = new product_attribute;
                $uoms = $product_attribute::getPossibleEnumValues('uom');
                $menu = $this->menu;
                return view('procurement.procurement',compact('users','products','uoms','menu'));
        }else
          return redirect()->route('backhome')->with("message",'You Don\'t have permission ');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(procurementRequest $procurementRequest,ProductRequest $productRequest,ProcurementDetailsRequest $arttributeRequest)
    {
        if(Auth::user()->hasRole('admin')){
        //echo "WE are save details"; exit;
        Activity::log('save procurement ', Auth::id());
        $procurement = new procurement;
        $procurement->total_budget = $procurementRequest->input('total_budget');
        $procurement->agent_id = $procurementRequest->input('agent_id');
        $procurement->save();

        
        $products =  $productRequest->input('product') ;
        $attribute = $arttributeRequest->input('attribute');
      
        for($i=0;$i<(sizeof($products['product_name'])-1);$i++)
        {
            $procurementDetail = new procurement_detail();
            $procurementDetail->procurement_id =$procurement->id;
         
            $procurementDetail->product_id =$products['product_name'][$i];
           $procurementDetail->uom= $attribute['uom'][$i];
           $procurementDetail->purchase_qty =$attribute['purchase_qty'][$i];
           $procurementDetail->save();
          
          
          
        }
        

        return redirect()->route('procurement.index')->with('procurement Added successfully');
        
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
         
        if(Auth::user()->hasRole('admin')|| Auth::user()->hasRole('owner') || Auth::user()->hasRole('agent')){
        
           $procurements = procurement::find($id);
           $user = $procurements->user;
          // $procurement_detail = $procurements->proDetails;
         $procurement_detail = procurement_detail::with('product')->where('procurement_id','=',$id)->get();  
       // dd($procurement_detail);
           $menu = $this->menu;
           
    //   dd($procurement_detail);
           return view('procurement.showprocurement',compact('procurements','procurement_detail','user','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission ');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('woner') || Auth::user()->can('edit_procurement')){

            Activity::log('user at  Edit procurement ', Auth::id());
            $procurements = procurement::find($id);
            $user = $procurements->user;
            $procurement_detail = $procurements->proDetails;
            $menu = $this->menu;
            return view('procurement.editprocurement',compact('procurements','procurement_detail','user','menu'));
        }else
            return redirect()->route('backhome')->with("message",'You Don\'t have permission ');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $productRequest,procurementRequest $procurementRequest, ProcurementDetailsRequest $arttributeRequest,procurement_expenseRequest $expnses, $id)
    {
        if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('woner') || Auth::user()->can('update_procurement')){
               Activity::log('user at  update procurement ', Auth::id());
                $procurement = new procurement;
                $products =  $productRequest->input('product') ;
                $procurements= $procurementRequest->input();
                 $attribute = $arttributeRequest->input('attribute');
               for($i=0;$i<sizeof($products['product_name']);$i++)
                { 
                    $procuremetDetailId =  $attribute['id'][$i];
                    $purchase_price= $attribute["purchase_price"][$i];
                    $expences= $attribute["expences"][$i];
                    procurement_detail::where('id', '=',$procuremetDetailId)
                    ->update(['purchase_price' => $purchase_price,'expenses' =>$expences]);
                }

                    $procurementExpense = new procurement_expense();
                    $procurementExpense->total_expenses =$expnses->input('total_expenses');
                    $procurementExpense->expense_reason =$expnses->input('expnses');
                    $procurementExpense->procurement_id= $id;
                    $procurementExpense->save();

        return redirect()->route('procurement.index')->with('procurement updated successfully');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

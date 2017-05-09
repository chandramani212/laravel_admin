<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\categoryRequest;
use App\category;
//use App\Http\Requests\CustomerRequest;
use DB;
class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        return view('category.categorylist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        return view('category.addcategory');
        //return view('products.addproduct',compact('uom','menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(categoryRequest $categoryRequest)
    {
        $category = new category;
        $category->category_name =$categoryRequest->get('category_name');
        $category->save();
       return redirect()->route('category.index')->with("message",'Item has added succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
            echo $id;
      //  $query = DB::table('users')->select('name');
        $categories = DB::table('categories')->where('id','=',$id)->select('category_name','id')->get();
        //dd($categories);
          return view('category.editcategory',compact('categories'));
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
        //
        echo $id ."Update categories";
        $category_name  = $request->get('category_name');
        DB::table('categories')
            ->where('id', $id)
            ->update(['category_name' =>  $category_name ]);
              return redirect()->route('category.index')->with("message",'Item has Updated succesfully');
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

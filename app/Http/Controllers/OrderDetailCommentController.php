<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\OrderDetailComment;

class OrderDetailCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         Activity::log('user at  create order details comment successfully ', Auth::id());
        $orderDetailCommentInsert = [
            //'order_by' => $request->get('last_name'),
            'qc_comment' => $request->get('qc_comment'),
            'comment_status' => $request->get('comment_status'),
            'created_by' =>Auth::id(),
        ];


         $orderDetailComment = OrderDetailComment::create($orderDetailCommentInsert);

         if($orderDetailComment->id > 0){

             return redirect()->route('orderDetailComment.index')
                            ->with('success','Order detail comment created successfully');
         }else{

              return redirect()->route('orderDetailComment.index')
                            ->with('success','Order detail comment created successfully');
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

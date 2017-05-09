<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class CustomPriceList extends Model
{
    //
    /*use SoftDeletes;
    protected $dates = ['deleted_at'];
    */

	protected $table = 'custom_price_list';
	protected $guarded = ['id','created_at'];
    
    public function product(){
        return $this->belongsTo('App\product','product_id');
    }

    public function attribute(){
        return $this->belongsTo('App\product_attribute','attribute_id');
    }

	public function customPrice(){

        return $this->belongsTo('App\CustomerPrice','custom_price_id');
	}

	public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }



}

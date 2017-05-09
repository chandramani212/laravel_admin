<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class CustomerProductAttributePriceDetail extends Model
{
    //
    /*use SoftDeletes;
    protected $dates = ['deleted_at'];
    */

	protected $table = 'customer_product_attribute_price_details';
	protected $guarded = ['id,created_at'];
    
   
	public function product(){
		return $this->belongsTo('App\product','product_id');
	}

	public function attribute(){
		return $this->belongsTo('App\product_attribute','attribute_id');
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

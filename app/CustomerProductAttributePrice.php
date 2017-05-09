<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class CustomerProductAttributePrice extends Model
{
    //
    /*use SoftDeletes;
    protected $dates = ['deleted_at'];
    */

	protected $table = 'customer_product_attribute_prices';
	protected $guarded = ['id,created_at'];
    
    public function customer(){
		return $this->belongsTo('App\Customer','customer_id');
	}

	public function address(){
		return $this->belongsTo('App\Address','address_id');
	}

	public function priceDetails(){

		return $this->hasMany('App\CustomerProductAttributePriceDetail','customer_pap_id');
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

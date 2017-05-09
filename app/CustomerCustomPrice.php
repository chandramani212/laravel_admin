<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class CustomerCustomPrice extends Model
{
    //
    /*use SoftDeletes;
    protected $dates = ['deleted_at'];
    */

	protected $table = 'customer_custom_prices';
	protected $guarded = ['id'];
    
    public function customer(){
		return $this->belongsTo('App\Customer','customer_id');
	}

	public function address(){
		return $this->belongsTo('App\Address','address_id');
	}

	public function customPrice(){

		return $this->belongsTo('App\CustomPrice','custom_price_id');
	}


}

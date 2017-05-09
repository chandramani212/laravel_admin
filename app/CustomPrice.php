<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class CustomPrice extends Model
{
    //
    /*use SoftDeletes;
    protected $dates = ['deleted_at'];
    */

	protected $table = 'custom_prices';
	protected $guarded = ['id','created_at'];
    
 	public function customerCustomPrices(){
 		return $this->hasMany('App\CustomerCustomPrice','custom_price_id');
 	}

	public function customPriceLists(){

		return $this->hasMany('App\CustomPriceList','custom_price_id');
	}

	public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function delete()
    {
      
        $this->customerCustomPrices()->delete();
        $this->customPriceLists()->delete();

        return parent::delete();
    }



}

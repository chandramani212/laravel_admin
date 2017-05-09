<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressHistory extends Model
{
    //
	protected $table = 'address_history';
	protected $guarded = ['id,created_at'];
    
    public function customer(){
		return $this->belongsTo('App\Customer','customer_id');
	}

	public function customerHistory(){
		return $this->belongsTo('App\CustomerHistory','customer_history_id');
	}

	public function locality(){
		return $this->belongsTo('App\Locality','locality_id');
	}

	public function city(){
		return $this->belongsTo('App\City','city_id');
	}

	public function state(){
		return $this->belongsTo('App\State','state_id');
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Address extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
	protected $table = 'address';
	protected $guarded = ['id,created_at'];
    
    public function customer(){
		return $this->belongsTo('App\Customer','customer_id');
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
	
	public function zone()
    {
        return $this->belongsTo('App\Zone','zone_id');
    }

    public function getFullAddress()
    {
    	$locality_name = isset($this->locality->locality_name)?$this->locality->locality_name:'';
    	$city_name = isset($this->city->city_name)?$this->city->city_name:'';
    	$state_name = isset($this->state->state_name)?$this->state->state_name:'';

    	$fullAddress  = $this->address_line1;
    	$fullAddress  .= ' '.$this->address_line2;
    	$fullAddress  .= ', '.$this->street;
    	$fullAddress  .= ', '.$locality_name;
    	$fullAddress  .= ', '.$city_name;
    	$fullAddress  .= ', '.$state_name;
    	$fullAddress  .= ' '.$this->pin_code;

    	$fullAddress = preg_replace('/,+/', ',', $fullAddress);
    	$fullAddress = preg_replace('/ +/', ' ', $fullAddress);

    	return trim($fullAddress);
    }
}

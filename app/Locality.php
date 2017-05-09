<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
	protected $table = 'locality';
	protected $guarded = ['id,created_at'];

	public function city(){
		return $this->belongsTo('App\City','city_id');
	}

	public function createdBy(){
		return $this->belongsTo('App\User','created_by');

	}

	public function updatedBy(){
		return $this->belongsTo('App\User','updated_by');

	}
}

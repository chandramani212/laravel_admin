<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	protected $table = 'city';
	protected $guarded = ['id,created_at'];

	public function state(){
		return $this->belongsTo('App\State','state_id');
	}

	public function createdBy(){
		return $this->belongsTo('App\User','created_by');

	}

	public function updatedBy(){
		return $this->belongsTo('App\User','updated_by');

	}
}

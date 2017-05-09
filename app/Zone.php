<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
	protected $table = 'zones';
	protected $guarded = ['id'];

	
	public function createdBy(){
		return $this->belongsTo('App\User','created_by');

	}

	public function updatedBy(){
		return $this->belongsTo('App\User','updated_by');

	}
}
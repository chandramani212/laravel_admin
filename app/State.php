<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';
	protected $guarded = ['id,created_at'];


	public function createdBy(){
		return $this->belongsTo('App\User','created_by');

	}

	public function updatedBy(){
		return $this->belongsTo('App\User','updated_by');

	}
}

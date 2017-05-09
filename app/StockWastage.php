<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class StockWastage extends Model
{
    protected $table = 'stock_wastage';
	protected $guarded = ['id,created_at'];

	public function stock(){

		return $this->belongsTo('App\Stock','stock_id');
	}

	public function updatedBy(){

		return $this->belongsTo(User::class,'updated_by');

	}

	public function addedBy(){

		return $this->belongsTo(User::class,'added_by');

	}
}

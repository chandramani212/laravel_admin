<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $table = 'stock_history';
	protected $guarded = ['id,created_at'];

	public function stock(){

		return $this->belongsTo('App\Stock','stock_id');
	}
}

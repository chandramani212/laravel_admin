<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetailHistory extends Model
{
    protected $table = 'order_detail_history';
	protected $guarded = ['id,created_at'];

	public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }

    public function orderHistory()
    {
        return $this->belongsTo('App\OrderHistory','order_history_id');
    }

}

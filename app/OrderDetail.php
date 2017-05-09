<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
	protected $guarded = ['id,created_at'];

	public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }

    public function orderDetailComments()
    {
        return $this->hasMany('App\OrderDetailComment','order_detail_id');
    }


}

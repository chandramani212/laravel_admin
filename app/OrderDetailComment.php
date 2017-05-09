<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetailComment extends Model
{
    protected $table = 'order_detail_comments';
	protected $guarded = ['id,created_at'];

	public function order()
    {
        return $this->belongsTo('App\OrderDetail','order_detail_id');
    }

}

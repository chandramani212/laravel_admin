<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history';
	protected $guarded = ['id,created_at'];


    public function order()
    {
        return $this->hasMany('App\Order','order_id');
    }

	public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail','order_id');
    }

    public function orderDetailHistory()
    {
        return $this->hasMany('App\OrderDetailHistory','order_history_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Address','address_id');
    }

    public function createdBy(){
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy(){
        return $this->belongsTo('App\User','updated_by');
    }

    public function delete()
    {
        // delete all related OrderDetials 
        $this->orderDetailHistory()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}

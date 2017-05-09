<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'orders';
	protected $guarded = ['id,created_at'];

    public function orderHistory()
    {
        return $this->hasMany('App\OrderHistory','order_id');
    }

	public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail','order_id');
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
        $this->orderDetails()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentReceipt extends Model
{
    //use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $table = 'payment_receipt';
	protected $guarded = ['id,created_at'];

    
    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Address','address_id');
    }

}

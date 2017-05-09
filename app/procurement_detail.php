<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\product;
class procurement_detail extends Model
{
    //
     protected $fillable =['product_id','purchase_qty','uom','budget_price','purchase_price','expenses'];

     public function product()
    {
    	 return $this->hasOne(product::class,'id', 'product_id' );
    }
}

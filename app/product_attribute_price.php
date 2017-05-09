<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\product_attribute;
class product_attribute_price extends Model
{
    protected $fillable = ['price','attribute_id','status','sale_price'];
     public function attribute()
    {
        return $this->belongsTO(product_attribute::class, 'id', 'attribute_id');
    }
	
	
	public function product_artribute()
	{
		//return $this->belongsTo('product');
		return $this->hasMany(product_artribute::class);
	}
}

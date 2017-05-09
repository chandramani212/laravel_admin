<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\product_attribute;
use App\product_attribute_price;

class product extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable =['product_name'];

    public function attributes(){
    	return $this->hasMany(product_attribute::class,'product_id');
    }
   
  
  	public function delete()
    {
      
        $this->attributes()->delete();
        return parent::delete();
    }


}

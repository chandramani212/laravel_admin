<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\product;
class product_attribute extends Model
{
    protected $fillable =['attribute_name','uom','id'];//,'product_id'

    public static function getPossibleEnumValues($name){
		$instance = new static; // create an instance of the model to be able to get the table name
		$type = DB::select( DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$name.'"') )[0]->Type;
		preg_match('/^enum\((.*)\)$/', $type, $matches);
		$enum = array();
		foreach(explode(',', $matches[1]) as $value){
		    $v = trim( $value, "'" );
		    $enum[] = $v;
			}
		return $enum;
	}
	public function price(){
    	  return $this->hasOne(product_attribute_price::class,'attribute_id', 'id');
    }

	public function product()
	{
		return $this->belongsTo(product::class,'product_id');
	}

	/*public function price()
    {
        return $this->hasMany(product_attribute_price::class,'attribute_id');
    }*/
}

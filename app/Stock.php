<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\product as Product;
use App\product_attribute as ProductAttribute;
use App\User;

class Stock extends Model
{
    protected $table = 'stocks';
	protected $guarded = ['id,created_at'];

	public function updatedBy(){

		return $this->belongsTo(User::class,'updated_by');

	}

	public function addedBy(){

		return $this->belongsTo(User::class,'added_by');

	}

	public function product(){

		return $this->belongsTo(Product::class,'product_id');
	}

	public function attribute(){

		return $this->belongsTo(ProductAttribute::class,'attribute_id');
	}

	public function history(){

		return $this->hasMany('App\StockHistory','stock_id');
	}

	public function wastages(){

		return $this->hasMany('App\StockWastage','stock_id');
	}

	public function delete(){

		$this->wastages()->delete();

		return parent::delete();
	}
}

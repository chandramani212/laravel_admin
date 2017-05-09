<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\procurement_detail;
use App\product;
use App\user;
class procurement extends Model
{
  	 protected $fillable=['total_budget','agent_id'];
  
	
	 public function proDetails(){
    	return $this->hasMany(procurement_detail::class,'procurement_id');
    }
    public function user()
    {
    	return $this->belongsTo(user::class,'agent_id');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'customers';
    /*protected $fillable = [
        'title',
        'description',
        'author'
    ];*/

    protected $guarded = ['id,created_at'];

    public function customerHistory()
    {
        return $this->hasMany('App\CustomerHistory','customer_id');
    }

    public function contactDetails()
    {
        return $this->hasMany('App\ContactDetail','customer_id');
    }

    public function introduceUser()
    {
        return $this->belongsTo('App\User','introduce_by');
    }

    public function manageUser()
    {
        return $this->belongsTo('App\User','manage_by');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }
	
	public function zone()
    {
        return $this->belongsTo('App\Zone','zone_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function address()
    {
        return $this->hasMany('App\Address','customer_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order','customer_id');
    }

    public function defaultOrder()
    {
        return $this->belongsTo('App\Order','default_order_id');
    }

    public function delete()
    {
      
        $this->address()->delete();
		$this->orders()->delete();
        $this->contactDetails()->delete();

        return parent::delete();
    }

    public function fullName(){

        $fullName  = $this->first_name;
        $fullName  .= ' '.$this->last_name;

        return(trim( $fullName ));
    }

}

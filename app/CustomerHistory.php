<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CustomerHistory extends Model
{
    protected $table = 'customer_history';
    /*protected $fillable = [
        'title',
        'description',
        'author'
    ];*/

    protected $guarded = ['id,created_at'];

    public function customers()
    {
        return $this->hasMany('App\Customer','customer_id');
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

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }

    public function address()
    {
        return $this->hasMany('App\Address','customer_id');
    }

    public function addressHistory()
    {
        return $this->hasMany('App\AddressHistory','customer_history_id');
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
        // delete all related photos 
        $this->address()->delete();
		
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }

}

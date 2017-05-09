<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    protected $table = 'contact_details';
    /*protected $fillable = [
        'title',
        'description',
        'author'
    ];*/

    protected $guarded = ['id,created_at'];


    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }


}

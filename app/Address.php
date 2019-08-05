<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table='Address';
    protected $fillable = [
        'city', 'postal-code', 'street', 'house_number', 'apartment_number', 'user_id'
    ];

    public function Order()
    {
        return $this->belongsTo('App\Order','address_id');
    }

    public function User()
    {
        return $this->hasMany('App\User','user_id');
    }
}

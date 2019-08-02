<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table='Address';
    protected $fillable = [
        'city', 'postal-code', 'street', 'house_number', 'apartment_number', 'user_id'
    ];
}

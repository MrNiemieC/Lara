<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Address extends Model
{
    use Sortable;
    protected $table='address';
    protected $fillable = [
        'city', 'postal_code', 'street', 'house_number', 'apartment_number', 'user_id'
    ];

    public function Order()
    {
        return $this->belongsTo('App\Order','id','address_id');
    }

    public function User()
    {
        return $this->hasMany('App\User','id','user_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'amount'
    ];

    public function Order()
    {
        return $this->belongsTo('App\Order','details_id');
    }
    public function Product()
    {
        return $this->hasMany('App\Product','product_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use Sortable;
    protected $fillable = [
        'user_id', 'status_id', 'address_id'
    ];
    public $sortable = ['created_at', 'updated_at'];

    public function Status()
    {
        return $this->hasOne('App\Status','status_id');
    }

    public function User()
    {
        return $this->hasOne('App\User','user_id');
    }

    public function Address()
    {
        return $this->hasOne('App\Address','address_id');
    }

    public function Detail()
    {
        return $this->belongsToMany('App\Order','details_id');
    }
}

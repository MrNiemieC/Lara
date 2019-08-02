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
    public $sortable = ['user_id', 'status_id', 'address_id', 'created_at', 'updated_at'];
}

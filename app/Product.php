<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'detail'
    ];
    public $sortable = ['name', 'created_at'];

    public function Order()
    {
        return $this->belongsToMany('App\Order','orders','product_id','order_id')
            ->withPivot('amount')->withTimestamps();
    }
}

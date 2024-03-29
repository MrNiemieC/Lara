<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'status';
    protected $fillable = [
        'name'
    ];

    public function Order()
    {
        return $this->belongsTo('App\Order','status_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function order_detail()
    {
        return $this->hasMany('App\Models\Order_detail'); 
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}

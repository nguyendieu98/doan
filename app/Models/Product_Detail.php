<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_Detail extends Model
{
    protected $table = 'product_details';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function store(){
        return $this->hasMany('App\Models\Store');   
    }
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
    public function order_detail(){
        return $this->hasMany('App\Models\Order_detail');   
    }
}

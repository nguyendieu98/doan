<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function order_detail()
    {
        return $this->HasMany('App\Models\Order_Detail');
    }
    public function product_detail()
    {
        return $this->hasMany('App\Models\Product_Detail'); 
    }
    public function image()
    {
        return $this->hasMany('App\Models\Image'); 
    }
}
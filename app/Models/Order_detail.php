<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $table = 'order_details';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }
    public function product_detail()
    {
        return $this->belongsTo('App\Models\Product_Detail'); 
    }
}

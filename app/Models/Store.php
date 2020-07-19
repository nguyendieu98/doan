<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function product_detail(){
        return $this->belongsTo('App\Models\Product_Detail','productdetail_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function product(){
    	return $this->hasOne('App\Models\Product');	
    }
}

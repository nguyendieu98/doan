<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
}

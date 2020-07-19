<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function user(){
        return $this->belongsTo('App\User');
    }
}

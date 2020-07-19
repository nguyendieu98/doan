<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
    public function permission()
    {
        return $this->belongsToMany('App\Models\Permission','permission_roles');
    }
}

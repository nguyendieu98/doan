<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_role extends Model
{
    protected $table = 'permission_roles';
    protected $guarded = ['id']; //Tat ca tru id
    protected $timestamp = true;
}

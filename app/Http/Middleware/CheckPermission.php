<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Auth;
use App\Models\Permission;
use App\User;
use contains;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        //Get list role of user 
        $roles = User::find(Auth::guard('admin')->user()->id)->role()->select('roles.id')->pluck('id')->toArray(); 
        //Get list permission of user
        $permissions = DB::table('roles')
            ->join('permission_roles', 'roles.id', '=', 'permission_roles.role_id')
            ->join('permissions', 'permission_roles.permission_id', '=', 'permissions.id')
            ->whereIn('roles.id',$roles)
            ->select('permissions.*')
            ->get()->pluck('id')->unique();   
        $checkpermission = Permission::where('name',$permission)->value('id');  
        if ($permissions->contains($checkpermission)) {
            return $next($request);    
        }  
        return response()->view('admin.error.401', [], 401);     
    }
}

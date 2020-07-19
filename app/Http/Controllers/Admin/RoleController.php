<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Role_user;
use App\Models\Permission_role;
use Carbon\Carbon;
use App\Http\Requests\RoleRequest;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::pluck('display_name','id');
        return view('admin.role.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    { 
        $request->validated();
        $role = new Role([
            'name' => $request->name,
            'display_name' => $request->name, 
            'updated_at' => null
        ]);
        $role->save();
        $role->permission()->attach($request->permission_id);
        if ($role){
            return redirect('/admin/role')->with('message','Create successfully!');
        }else{
            return back()->with('err','Create error!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id); 
        $permissions = Permission::pluck('display_name','id')->toArray(); 
        $list_permissions = Permission_role::where('role_id',$id)->pluck('permission_id'); 
        return view('admin.role.edit',compact('role','list_permissions','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    { 
        $request->validated();
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name; 
        $role->updated_at = Carbon::now()->toDateTimeString();
        $role->update();
        DB::table('permission_roles')->where('role_id',$id)->delete();
        $role->permission()->attach($request->permission_id);
        if ($role){
            return redirect('/admin/role')->with('message','Update successfully!');
        }else{
            return back()->with('err','Update error!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    { 
        $role = Role::findOrFail($request->id);
        $role->delete($request->id);
        $role->permission()->detach();
        if ($role){
            return redirect('/admin/role')->with('message','Delete successfully!');
        }else{
            return back()->with('err','Delete error!');
        }
    }
}

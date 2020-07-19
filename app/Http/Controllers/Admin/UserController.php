<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use App\Models\Role_user;
use Carbon\Carbon;
use DB;
use Auth;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('display_name','id')->toArray(); 
        return view('admin.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $roles = Role::pluck('display_name','id')->toArray(); 
        $user = User::findOrFail($id);
        $list_roles = Role_user::where('user_id',$id)->pluck('role_id'); 
        return view('admin.user.edit',compact('user','roles','list_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  
        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->updated_at = Carbon::now()->toDateTimeString();
        $user->update();
        DB::table('role_user')->where('user_id',$id)->delete();
        $user->role()->attach($request->role_id);
        if ($user){
            return redirect('/admin/user')->with('message','Update successfully!');
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
        $user = User::findOrFail($request->id);
        $user->delete($request->id);
        $user->role()->detach();
        if ($user){
            return redirect('/admin/user')->with('message','Delete successfully!');
        }else{
            return back()->with('err','Delete error!');
        }
    }

    // Change Password
    public function showAdminChangePassForm() 
    {
        return view('admin.user.changePass');
    }

    public function changeAdminPassword(Request $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Current password is incorrect. Try again.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Choose a different password.");
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|same:new_confirm_password',
            'new_confirm_password' => 'required',
        ],
        [
            'current_password.required' => 'Field current password is required.',
            'new_password.required' => 'Field new password is required.',
            'new_confirm_password' => 'Field new confirm password is required.',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with("success","Password changed successfully !");
    }
    // End Change Password
}

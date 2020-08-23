<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Comment;
use App\User;
use Auth;
use Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:client');
    }
    public function index(Request $request)
    {
        $abouts = About::take(1)->get();
        $user_id = Auth::guard('client')->user()->id; 
        $orders = Order::orderBy('created_at','desc')->where('user_id',$user_id);
        if ($request->status) {
            $orders = $orders->where('status',$request->status);            
        } 
        $orders = $orders->paginate(4)->appends(request()->query());
        $quantity = array();
        $quantity[] = Order::where('user_id',$user_id)->count();
        $quantity[] = Order::where('status','unconfimred')->where('user_id',$user_id)->count();
        $quantity[] = Order::where('status','confimred')->where('user_id',$user_id)->count();
        $quantity[] = Order::where('status','delivery')->where('user_id',$user_id)->count();
        $quantity[] = Order::where('status','delivered')->where('user_id',$user_id)->count();
        $quantity[] = Order::where('status','cancel')->where('user_id',$user_id)->count(); 
        return view('user.profile.info',compact('abouts','orders','quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit($username)
    {
        $users = User::where('username', $username)->first();
        $abouts = About::take(1)->get(); 
        return view('user.profile.edit',compact('users','abouts'));
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
        // Validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'.$id
        ],
        [
            'first_name.required' => trans('editprofile.firstnameRequired'),
            'last_name.required' => trans('editprofile.lasnameRequired'),
            'address.required' => trans('editprofile.addressRequired'),
            'phone.required' => trans('editprofile.phoneRequired'),
            'email.required' => trans('editprofile.emailRequired'),
            'email.email' => trans('editprofile.emailcheck'),
            'email.unique' => trans('editprofile.emailunique'),
        ]);

        $users= User::findOrfail($id);
        if (isset($users))
        {
            $users->first_name = $request->first_name;
            $users->last_name = $request->last_name;
            $users->address = $request->address;
            $users->phone = $request->phone;
            $users->email = $request->email;
            $users->isdelete = false;
            $users->update();
        }else{
            return back()->with('err','Save error!');
        }
        return redirect('/profile')->with("message",trans('profileUser.Editprofile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }  
    public function feedback()
    {
        return view('user.profile.feedback');
    }
    public function orderdetail($order_code)
    { 

        $abouts = About::take(1)->get(); 
        $user_id = Auth::guard('client')->user()->id;
        $order = Order::select('status','id')->where('order_code',$order_code)->first(); 
        $order_details = Order_detail::select('order_details.*')->join('orders','orders.id','order_details.order_id')->where('orders.user_id',$user_id)->where('order_details.order_id',$order->id)->orderBy('order_details.created_at','desc')->get();   
        return view('user.profile.orderdetail',compact('abouts','order_details','order'));
    }
    public function comment(Request $request)
    { 
        $user_id = Auth::guard('client')->user()->id;
        $comment = new Comment([
            'content' => $request->comment,
            'star' => $request->star,
            'user_id' => $user_id, 
            'product_id' => $request->product_id, 
            'isdelete' => false,
            'isdisplay' => false,
            'updated_at' => null
        ]); 
        $order_detail= Order_detail::findOrfail($request->order_detail_id);
        $order_detail->isfeedback = true;
        $order_detail->update();
        $comment->save();
        return back();
    }
    public function received(Request $request)
    { 
        $order = Order::findOrFail($request->order_id);
        $order->status = 'delivered';
        $order->update();
        return back();
    }
    public function showChangePassForm() 
    {
        $abouts = About::take(1)->get(); 
        return view('user.profile.changePass',compact('abouts'));
    }

     public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error",trans('editpass.checkpass'));
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error",trans('editpass.checkpassnew'));
        }

        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|same:new_confirm_password',
            'new_confirm_password' => 'required',
        ],
        [
            'current_password.required' => 'Field current password is required.',
            'new_password.required' => trans('editpass.newpasswordRequired'),
            'new_password.same' => trans('editpass.passsame'),
            'new_password.min' => trans('editpass.passmin'),
            'new_confirm_password.required' => trans('editpass.cfnewpasswordRequired'),
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save(); 
        return redirect('/profile')->with("message",trans('profileUser.Editpass'));
    }
    public function cancelOrder(Request $request)
    { 
        $order = Order::findOrFail($request->order_id);
        $order->status = 'cancel';
        $order->update(); 
        return back();
    }
}

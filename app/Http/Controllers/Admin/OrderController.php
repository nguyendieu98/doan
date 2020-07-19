<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use App\Models\Order_detail;
use App\Models\Product_Detail;
use App\Models\Product;
use App\User;
use Carbon\Carbon;
use Auth;

class OrderController extends Controller
{
    // Kiem tra xac thuc khi admin chua dang nhap
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
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.order.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_details = Product_Detail::orderBy('created_at', 'desc')->where('isdelete',false)->get();
        return view('admin.order.create',compact('product_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $total_amount = 0;
        foreach ($request->product_detail_id as $key => $value) {
            $product_id = Product_Detail::select('product_id')->where('id',$value)->first();
            $price = Product::select('price')->where('id',$product_id->product_id)->first();
            $total_amount += $price->price * $request->quantity[$key] ; 
        }
        $order = new Order([
            'order_code' => $request->product_code,
            'total_amount' => $total_amount,
            'status' => 'delivered',
            'payment' => 'transfer',
            'transaction_date' => Carbon::now()->toDateTimeString(),
            'notes' => $request->notes,
            'user_id' => null,
            'created_by' => Auth::guard('admin')->user()->id,
            'updated_at' => null,
        ]);
        $order->save();
        foreach ($request->product_detail_id as $key => $value) {
            $product_id = Product_Detail::select('product_id')->where('id',$value)->first();
            $price = Product::select('price')->where('id',$product_id->product_id)->first();
            $order_detail = new Order_detail([
                'quantity' => $request->quantity[$key],
                'price' => $price->price,
                'total_amount' => $request->quantity[$key] * $price->price,
                'order_id' => $order->id,
                'product_detail_id' => $value,
                'isfeedback' => false,
                'created_by' => Auth::guard('admin')->user()->id,
                'updated_by' => null
            ]);
            $order_detail->save();
        }
        if ($order){
            return redirect('/admin/order')->with('message','Create New successfully!');
        }else{
            return back()->with('err','Save error!');
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
        $order = Order::findOrFail($id);
        return view('admin.order.edit',compact('order'));
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
        $order= Order::findOrfail($id);
        if (isset($order))
        {
            $order->status = $request->status;
            $order->updated_at = Carbon::now()->toDateTimeString() ;
            $order->updated_by = Auth::guard('admin')->user()->id;
            $order->update();
        }else{
            return back()->with('err','Save error!');
        }
        return redirect('admin/order')->with('message','Edit successfully!');
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
    public function getQuantity(Request $request)
    {
        if ($request->ajax()) {
            $quantity = Store::select('quantity')->where('isdelete',false)->where('productdetail_id',$request->product_detail_id)->first(); 
            if ($quantity) {
                return Response($quantity->quantity);
            }
            return Response(0);
        }
    }
    public function getOrderDetail(Request $request)
    {
        $order = Order::findOrfail($request->id);
        $order_details = Order_detail::orderBy('created_at', 'desc')->where('order_id',$request->id)->get();
        $user = '';
        if ($order->user_id) {
            $user = User::findOrfail($order->user_id);
        } 
        $name = array();
        $product_details = array();
        foreach ($order_details as $key => $value) {
            $name[] = Product::select('products.name')->join('product_details','product_details.product_id','=','products.id')->join('order_details','order_details.product_detail_id','=','product_details.id')->where('product_details.id',$value->product_detail_id)->first();
            $product_details[] = Product_Detail::select('product_details.size','product_details.color')->join('order_details','order_details.product_detail_id','=','product_details.id')->where('order_details.product_detail_id',$value->product_detail_id)->first(); 
        }
        return response()->json(array('success'=> true, 'names' => $name,'order_details'=> $order_details, 'product_details' => $product_details, 'users'=> $user,'orders'=>$order)); 
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\Product_Detail;
use App\Http\Requests\StoreRequest;
use Carbon\Carbon;
use Auth;

class StoreController extends Controller
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
    public function index(Request $request)
    {
        $stores = Store::orderBy('created_at', 'desc')->where('isdelete',false);
        if ($request->name) {
            $stores = Store::join('product_details', 'stores.productdetail_id', '=', 'product_details.id')
            ->join('products', 'product_details.product_id', '=', 'products.id')->where('products.name','like','%'.$request->name.'%')->where('stores.isdelete',false);
        } 
        $stores = $stores->paginate(5)->appends(request()->query());
        $products = Product::where('isdelete',false)->orderBy('created_at', 'desc')->pluck('name','id')->toArray();
        return view('admin.store.index',compact('stores','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('isdelete',false)->orderBy('created_at', 'desc')->pluck('name','id')->toArray();
        return view('admin.store.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $request->validated();
        $productdetail_id = Product_Detail::select('id')->where('isdelete',false)->where('product_id',$request->product_id)->where('size',$request->size)->where('color',$request->color)->first();
        $store_id = Store::select('id')->where('isdelete',false)->where('productdetail_id',$productdetail_id->id)->first();
        if ($store_id) {
            $store= Store::findOrfail($store_id->id);
            $store->quantity = $request->quantity;
            $store->updated_at = Carbon::now()->toDateTimeString() ;
            $store->update();
            if ($store){
                return redirect('/admin/store')->with('message','Update successfully!');
            }else{
                return back()->with('err','Update error!');
            }
        }else{
            $store = new Store([
                'productdetail_id' => $productdetail_id->id,
                'quantity' => $request->quantity,
                'isdelete' => false,
                'isdisplay' => false,
                'created_by' => Auth::guard('admin')->user()->id,
                'updated_at' => null
            ]);
            $store->save();
            if ($store){
                return redirect('/admin/store')->with('message','Create successfully!');
            }else{
                return back()->with('err','Save error!');
            }
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
        $store = Store::findOrFail($id);
        return view('admin.store.edit',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        $request->validated();
        $store = Store::findOrFail($id);
        $store->quantity = $request->quantity;
        $store->updated_at = Carbon::now()->toDateTimeString();
        $store->update();
        if ($store){
            return redirect('/admin/store')->with('message','Update successfully!');
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
        $store = Store::findOrFail($request->id);
        $store->delete($request->id); 
        if ($store){
            return redirect('/admin/store')->with('message','Delete successfully!');
        }else{
            return back()->with('err','Delete error!');
        }
    }
    public function getListSize(Request $request)
    {
        if ($request->ajax()) {
            $product_details = Product_Detail::select('size')->where('isdelete',false)->where('product_id',$request->product_id)->get();
            $list = array();
            foreach ($product_details as $key => $product_detail) {
                $list[] = $product_detail->size;
            }
            $list = array_unique($list);
            return Response($list);
        }
    }
    public function getListColor(Request $request)
    {
        if ($request->ajax()) {
            $product_details = Product_Detail::select('color')->where('isdelete',false)->where('product_id',$request->product_id)->where('size',$request->size)->get();
            $list = array();
            foreach ($product_details as $key => $product_detail) {
                $list[] = $product_detail->color;
            }
            $list = array_unique($list);
            return Response($list);
        }
    }
    public function getQuantity(Request $request)
    {
        if ($request->ajax()) {
            $productdetail_id = Product_Detail::select('id')->where('isdelete',false)->where('product_id',$request->product_id)->where('size',$request->size)->where('color',$request->color)->first();
            $quantity = Store::select('quantity')->where('isdelete',false)->where('productdetail_id',$productdetail_id->id)->first();
            if ($quantity) {
                return Response($quantity->quantity);
            }else{
                return Response('0');
            } 
        }
    }
}

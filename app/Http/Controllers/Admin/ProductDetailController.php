<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Product_Detail;
use App\Models\Product;

class ProductDetailController extends Controller
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
        $product_details = Product_Detail::orderBy('product_details.created_at', 'desc')->where('product_details.isdelete',false);
        if ($request->name) {
            $product_details = $product_details->join('products','product_details.product_id','=','products.id')->where('products.name','like','%'.$request->name.'%'); 
        } 
        $product_details = $product_details->paginate(10)->appends(request()->query());
        return view('admin.productdetail.index',compact('product_details'));
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product_detail = Product_Detail::findOrFail($request->id);
        if ($product_detail) {
            $product_detail->isdelete = true;
            $product_detail->update();
            return back()->with('message','Delete success!');
        } else {
            return back()->with('err','Delete failse!');
        }  
    }
}

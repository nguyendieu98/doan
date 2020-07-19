<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Image;
use App\Models\Product_Detail;
use Session;
use Validator;
use Illuminate\Support\Str; 
use DB;
use Carbon\Carbon;
use Auth;

class ProductController extends Controller
{
    // Kiem tra xac thuc khi admin chua dang nhap
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function getCategory()
    {
        $categories = Category::orderBy('created_at', 'desc')->where('isdelete',false)->get();
        return $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->where('isdelete',false);
        $categories = Category::where('isdelete',false)->pluck('name','name')->toArray();
        if ($request->name) {
            $products = $products->where('name','like','%'.$request->name.'%'); 
        } 
        $products = $products->paginate(10)->appends(request()->query());
        return view('admin.product.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brand::where('isdelete',false)->pluck('name','id')->toArray();
        $category = Category::where('isdelete',false)->pluck('name','id')->toArray();
        return view('admin.product.create',compact('brand','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    { 
        $request->validated();
        if($request->hasFile('image'))
        {
            $imagename=$request->image->getClientOriginalName();
            $request->image->move('images', $imagename);
        }
        $product = new  Product();
        $product->product_code = $request->product_code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->slug = Str::slug($request->slug ? $request->slug : $request->name);
        $product->image = $imagename;
        $product->promotion = $request->promotion;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->isdelete = false;
        $product->isdisplay = false;
        $product->created_by = Auth::guard('admin')->user()->id;
        $product->updated_at = null;
        $product->save();
        foreach ($request->size as $key => $size) {
            $colors = 'color'.$key;
            $colors = $request->$colors;
            foreach ($colors as $key => $color) {
                $product_detail = new Product_Detail([
                    'product_id' => $product->id,
                    'size' => $size,
                    'color' => $color,
                    'isdelete' => false,
                    'isdisplay' => false,
                    'updated_at' => null
                ]);
                $product_detail->save();
            }
        }
        if ($request->listimage) {
            $lists = array_unique($request->listimage);
            foreach ($lists as $key => $value) {
                $image = new Image([
                    'product_id' => $product->id,
                    'name' => $value,
                    'created_by'=> Auth::guard('admin')->user()->id,
                    'updated_at' => null
                ]);
                $image->save();
            }
        } 
        if ($product){
            return redirect('/admin/product')->with('message','Create successfully!');
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
        $product = Product::findOrfail($id);
        return view('admin.product.detail',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrfail($id);
        $brand = Brand::where('isdelete',false)->pluck('name','id')->toArray();
        $category = Category::where('isdelete',false)->pluck('name','id')->toArray();
        $product_details = Product_Detail::where('isdelete',false)->where('product_id',$id)->get();
        return view('admin.product.edit',compact('brand','category','product','product_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        if($product)
        {
            if ($request->hasFile('imagee') )
            {
                $imagename=$request->imagee->getClientOriginalName();
                $request->imagee->move('images', $imagename);
            }else{
                $imagename = $request->image;
            }
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->slug = Str::slug($request->slug ? $request->slug : $request->name);
            $product->image = $imagename;
            $product->promotion = $request->promotion;
            $product->brand_id = $request->brand_id;
            $product->category_id = $request->category_id;
            $product->updated_at = Carbon::now()->toDateTimeString();
            $product->isdelete = false;
            $product->isdisplay = $request->isdisplay;
            $product->updated_at = Carbon::now()->toDateTimeString();
            $product->updated_by = Auth::guard('admin')->user()->id;
            $product->update();
            if ($request->size) {
                foreach ($request->size as $key => $size) {
                    $colors = 'color'.$key;
                    $colors = $request->$colors;
                    foreach ($colors as $key => $color) {
                        $product_detail = new Product_Detail([
                            'product_id' => $id,
                            'size' => $size,
                            'color' => $color,
                            'isdelete' => false,
                            'isdisplay' => false,
                            'updated_at' => null
                        ]);
                        $product_detail->save();
                    }
                }
            }
            return redirect('/admin/product')->with('message','Update successfully!');
        }
        return back()->with('err','Update err!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product_details = Product_Detail::select('id')->where('product_id', $product->id)->get();
        if ($product) {
            $product->isdelete = true;
            $product->update();
            foreach ($product_details as $key => $value) {
                $product_detail = Product_Detail::findOrFail($value->id);
                $product_detail->isdelete = true;
                $product_detail->update();
            }
            return back()->with('message','Delete success!');
        } else {
            return back()->with('err','Delete failse!');
        }  
    }
    public function setvalue(Request $request)
    {
        if ($request->ajax()) {
            $value = class_basename($request->value);
            return Response($value);
        }
    }
    public function getcolor(Request $request)
    {
        if ($request->ajax()) {
            $colors = Product_Detail::select('color')->where('isdelete',false)->where('product_id',$request->id)->where('size',$request->size)->get();
            return Response($colors);
        }
    }
    public function moveImage(Request $request)
    {
        if ($request->file('filename2')) {
            $imagename=$request->filename2->getClientOriginalName();
            $request->filename2->move('images', $imagename);
            return Response($imagename);
        }
    }
    public function getListImage(Request $request)
    {
        if ($request->ajax()) {
            $images = Image::select('id','name')->where('product_id',$request->product_id)->orderBy('created_at', 'desc')->get();
            $list = array();
            $id = array();
            foreach ($images as $key => $value) {
                $list[] = $value->name;
                $id[] = $value->id;
            }
            return response()->json(array('success'=> true, 'lists' => $list,'ids'=> $id));
        }
    }
    public function saveImage(Request $request)
    {
        if ($request->ajax()) {
            $nameimage = class_basename($request->nameimage);
            $images = Image::select('id')->where('product_id',$request->product_id)->where('name',$nameimage)->first();
            if (isset($images->id)) {
                return response('0');
            }
            $image = new Image([
                'product_id' => $request->product_id,
                'name' => $nameimage,
                'created_by'=> Auth::guard('admin')->user()->id,
                'updated_at' => null
            ]);
            $image->save();
            return response($image->id);
        }
    }
    public function deleteImage(Request $request)
    {
        if ($request->ajax()) {
            $image = Image::findOrFail($request->id);
            $image->delete();
            return response($request->id);
        }
    }
}
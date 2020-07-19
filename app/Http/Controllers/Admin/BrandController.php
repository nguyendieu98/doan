<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Session;
use App\Http\Requests\BrandRequest;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use Auth;

class BrandController extends Controller
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
        //1.Lay du lieu trong Model
        $brands = Brand::orderBy('created_at', 'desc')->where('isdelete',false)->get();
        if ($request->searchname) {
            $brands = Brand::orderBy('created_at', 'desc')->where('isdelete',false)->where('name','like','%'.$request->searchname.'%')->get(); 
        } 
        //2.Do du lieu ra view
        return view('admin.brand.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $request->validated();
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->slug = Str::slug($request->slug ? $request->slug : $request->name);
        $brand->isdelete = false;
        $brand->isdisplay = false;
        $brand->created_by = Auth::guard('admin')->user()->id;
        $brand->updated_at = null;
        $brand->save();
        Session::flash('message','Save successfully!');
        Session::flash('err','Save err!');
        if ($brand){
            return redirect('/admin/brand')->with('message','Create successfully!');
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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.detail',compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $request->validated();
        $brand= Brand::findOrfail($id);
        if (isset($brand))
        {
            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->slug = $request->slug ? $request->slug : $request->name;
            $brand->isdelete = false;
            $brand->isdisplay = $request->isdisplay;
            $brand->updated_at = Carbon::now()->toDateTimeString();
            $brand->updated_by = Auth::guard('admin')->user()->id;
            $brand->update();
        }else{
            return back()->with('err','Save error!');
        }
        return redirect('admin/brand')->with('message','Edit successfully!');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $product = Product::where('brand_id', $brand->id)->get();
        if ($brand && $product->count()==0){
            $brand->isdelete = true;
            $brand->update();
        }else{
            return redirect("admin/brand")->with('err','Data is being used on the product side!');
        }
        return redirect("admin/brand")->with('message','Delete successfully!');
    }
}
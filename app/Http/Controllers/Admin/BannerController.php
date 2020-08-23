<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Banner;
use Session;
use App\Http\Requests\BannerRequest;
use Carbon\Carbon;
use DB;
class BannerController extends Controller
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
        $banners = Banner::orderBy('created_at', 'desc')->where('isdelete',false)->get();
        return view('admin.banner.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {

      if($request->hasFile('url_img')){
        $url_img=$request->url_img->getClientOriginalName();
        $request->url_img->move('images', $url_img);
        $banner = new Banner;
        $banner->link = $request->link;
        $banner->url_img = $url_img;
        $banner->updated_at = null;
        $banner->isdelete = false;
        $banner->isdisplay = false;
        $banner->save();
        if ($banner){
           return redirect('/admin/banner')->with('message','Create Newsuccessfully!');
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
        $banner = Banner::findOrFail($id);
        return view('admin.banner.detail',compact('banner'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banner.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        if (isset($banner))
        {
            if ($request->hasFile('image')){
                $url = $request->image->getClientOriginalName();
                $request->image->move('images', $url);
            }else{
                $url = $request->url_img;
            } 
            $banner->link = $request->link;
            $banner->url_img = $url; 
            $banner->updated_at = Carbon::now()->toDateTimeString();
            $banner->isdelete = false;
            $banner->isdisplay = $request->isdisplay;
            $banner->update();
        }else{
            return back()->with('err','Save error!');
        }
        return redirect('admin/banner
            ')->with('message','Edit successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $banners = Banner::findOrFail($request->id);
        if ($banners){
            $banners->isdelete = true;
            $banners->update();
        }
        return redirect("admin/banner")->with('message','Delete successfully!');
    }
}
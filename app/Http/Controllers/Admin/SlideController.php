<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Slide;
use Session;
use App\Http\Requests\SlideRequest;
use Carbon\Carbon;
use DB;
class SlideController extends Controller
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
        $slides = Slide::orderBy('created_at', 'desc')->where('isdelete',false)->get();
        return view('admin.slide.index',compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {

      if($request->hasFile('url_img')){
        $url_img=$request->url_img->getClientOriginalName();
        $request->url_img->move('images', $url_img);
        $slide = new Slide;
        $slide->link = $request->link;
        $slide->url_img = $url_img;
        $slide->updated_at = null;
        $slide->isdelete = false;
        $slide->isdisplay = false;
        $slide->save();
        if ($slide){
           return redirect('/admin/slide')->with('message','Create Newsuccessfully!');
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
        $slide = Slide::findOrFail($id);
        return view('admin.slide.detail',compact('slide'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        return view('admin.slide.edit',compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SlideRequest $request, $id)
    {
        $slide = Slide::findOrFail($id);
        if (isset($slide))
        {
            if ($request->hasFile('image')){
                $url = $request->image->getClientOriginalName();
                $request->image->move('images', $url);
            }else{
                $url = $request->url_img;
            } 
            $slide->link = $request->link;
            $slide->url_img = $url; 
            $slide->updated_at = Carbon::now()->toDateTimeString();
            $slide->isdelete = false;
            $slide->isdisplay = $request->isdisplay;
            $slide->update();
        }else{
            return back()->with('err','Save error!');
        }
        return redirect('admin/slide
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
        $slides = Slide::findOrFail($request->id);
        if ($slides){
            $slides->isdelete = true;
            $slides->update();
        }
        return redirect("admin/slide")->with('message','Delete successfully!');
    }
}
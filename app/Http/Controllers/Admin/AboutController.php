<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\About;
use Session;
use App\Http\Requests\AboutRequest;
use Carbon\Carbon;
use DB;
use Auth;
class AboutController extends Controller
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
        $abouts= DB::table('abouts')->get();
        return view('admin.about.index',compact('abouts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutRequest $request)
    {
        if($request->hasFile('logo')){
            $logo=$request->logo->getClientOriginalName();
            $request->logo->move('images', $logo);
            $about = new About;
            $about->title = $request->title;
            $about->name = $request->name;
            $about->phone = $request->phone;
            $about->content = $request->content;
            $about->email = $request->email;
            $about->logo = $logo;
            $about->address = $request->address;
            $about->created_by = Auth::guard('admin')->user()->id;
            $about->save();
            if ($about){
                return redirect('/admin/about')->with('message','Create New successfully!');
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
        $about = About::findOrFail($id);
        return view('admin.about.detail',compact('about'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.about.edit',compact('about'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AboutRequest $request, $id)
    {

        $about = About::findOrFail($id);
        if($request->hasFile('logoo')){
            $logo=$request->logoo->getClientOriginalName();
            $request->logoo->move('images', $logo);
        }else{
            $logo = $request->logo;
        } 
        $about->title = $request->title;
        $about->name = $request->name;
        $about->phone = $request->phone;
        $about->content = $request->content;
        $about->email = $request->email;
        $about->logo = $logo;
        $about->address = $request->address;
        $about->updated_at = Carbon::now()->toDateTimeString();
        $about->updated_by = Auth::guard('admin')->user()->id;
        $about->update();
        return redirect('admin/about')->with('message','Edit successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $about = About::findOrFail($request->id);
        if ($about){
            $about->delete();
        }
        return redirect("admin/about")->with('message','Delete successfully!');
    }
}
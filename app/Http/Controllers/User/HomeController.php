<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Store;
use App\Models\Image;
use App\Models\Product_Detail;
use App\Models\About;
use App\Models\Slide;
use App\Models\Comment;
use Session;
use Validator;
use Illuminate\Support\Str; 
use DB;
use Carbon\Carbon;
use Auth;
use Mail;

class HomeController extends Controller
{
    // Kiem tra xac thuc khi client chua dang nhap
    // public function __construct()
    // {
    //     $this->middleware('auth:client');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::where('products.isdelete',false)->where('products.isdisplay',true);
        $abouts = About::take(1)->get(); 
        $categories = Category::where('isdelete',false)->where('isdisplay',true)->get();
        //Get list color 
        $colors = Product_Detail::select('color')->where('isdelete',false)->get();
        $list = array();
        foreach ($colors as $key => $color) {
            $list[] = $color->color;
        }
        $list = array_unique($list);
        //count product by color
        $listcolorquantity = array();
        foreach ($list as $key => $value) {
            $quantity = Product::join('product_details','products.id','product_details.product_id')->where('product_details.color',$value)->where('products.isdelete',false)->where('product_details.isdelete',false)->where('products.isdisplay',true)->count();
            $listcolorquantity += array($value => $quantity);
        }
        foreach ($categories as $key => $value) {
            $listquantity[] = $this->countProduct($value->id);
        }
        if ($request->category) { 
            $listcate = $request->category;
            $products = $products->where(function($query) use($listcate){
                foreach ($listcate as $key => $value) {
                    $category_id = Category::where('slug',$value)->take(1)->get();
                    $query = $query->orwhere('category_id',$category_id[0]->id); 
                } 
            }); 
        }
        if ($request->productname) {
            $products = $products->where('name', 'like', '%'.$request->productname.'%');
        }
        if ($request->price) { 
            $listprice = $request->price; 
            $products = $products->where(function($query) use($listprice){
                foreach ($listprice as $key => $value) {
                    preg_match_all('!\d+!', $value, $matches); 
                    if (count($matches[0]) == 2) {
                        $query = $query->orwhere('price', '>',$matches[0][0])->where('price', '<',$matches[0][1]);
                    }else{ 
                        $condition = substr($value,0,3);
                        if ($condition == 'max') {
                            $condition = '<';
                        }else{
                            $condition = '>';
                        } 
                        $query = $query->orwhere('price',$condition,$matches[0][0]);
                    }
                } 
            }); 
        }
        if ($request->color) {
            $listcolor = $request->color;
            $products = $products->join('product_details','products.id','product_details.product_id')->where(function($query) use($listcolor){
                foreach ($listcolor as $key => $value) { 
                    $query = $query->orwhere('product_details.color',$value); 
                } 
            });  
        }
        if ($request->sale) {
            $products = $products->where('promotion','<>','0');
        }
        if ($request->orderby) {
            $products = $products->orderBy('price',$request->orderby);
        }else{
            $products = $products->orderBy('products.created_at','desc');
        }
        $products = $products->paginate(12)->appends(request()->query());
        $star = Comment::select('star','product_id')->where('isdisplay',true)->where('isdelete',false)->get();
        return view('user.home.product',compact('products','abouts','categories','listquantity','listcolorquantity','star'));
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
    public function show($slug)
    {
        $categories = Category::where('isdelete','0')->get(); 
        $product = Product::where('slug',$slug)->first();
        $productbycategories = Product::where('category_id',$product->category_id)->where('id','<>',$product->id)->orderBy('created_at','desc')->take(10)->get();
        $colors = DB::table('product_details')->where('product_id',$product->id)->get();
        $sizes = DB::table('product_details')->where('product_id',$product->id)->get();
        $abouts = About::take(1)->get(); 
        $images = Image::where('product_id',$product->id)->get();
        $quantities = Store::select('quantity')->join('product_details', 'product_details.id', '=', 'stores.productdetail_id')->where('stores.isdelete',false)->where('product_details.product_id',$product->id)->get();
        $quantity = 0;
        foreach ($quantities as $key => $value) {
            $quantity += $value->quantity;
        }
        $comments = Comment::where('isdisplay',true)->where('isdelete',false)->where('product_id',$product->id)->get();
        //Top rating
        $list_product_vote_id = $this->topVote();
        $list_product_votes = array();
        foreach ($list_product_vote_id as $key => $value) { 
            $list_product_votes[] = Product::where('isdelete',false)->where('isdisplay',true)->where('id',$key)->get()->toArray();
        }  
        return view('user.home.productdetail',compact('product','categories','abouts','colors','sizes','quantity','images','productbycategories','comments','list_product_votes','list_product_vote_id'));
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
    public function destroy($id)
    {
        //
    }
   
    public function homepage()
    {
        $abouts = About::take(1)->get();
        $newproducts = Product::where('isdelete',false)->where('isdisplay',true)->orderBy('created_at','desc')->take(10)->get();
        $categories = Category::where('isdelete','0')->where('isdisplay','1')->get(); 
        $listquatity = array();
        $product_promotions = Product::where('promotion','<>','')->where('isdelete','0')->where('isdisplay','1')->orderBy('created_at','desc')->get(); 
        $slides = Slide::where('isdelete','0')->where('isdisplay','1')->get(); 
        //Top rating
        $list_product_vote_id = $this->topVote();
        $list_product_votes = array();
        foreach ($list_product_vote_id as $key => $value) { 
            $list_product_votes[] = Product::where('isdelete',false)->where('isdisplay',true)->where('id',$key)->get()->toArray();
        }  
        return view('user.home.home',compact('abouts','product_promotions','categories','slides','newproducts','list_product_votes','list_product_vote_id'));
    }
    public function countProduct($id)
    {
        $quantity = Product::where('category_id',$id)->where('isdisplay','1')->count(); 
        return $quantity;
    }
    public function getQuantity(Request $request)
    {
        if ($request->ajax()) {
            $quantity = 0;
            if ($request->color) {
                $quantities = Store::select('quantity')->join('product_details', 'product_details.id', '=', 'stores.productdetail_id')->where('product_details.product_id',$request->product_id)->where('stores.isdelete',false)->where('product_details.size',$request->size)->where('product_details.color',$request->color)->get();
            }else{
                $quantities = Store::select('quantity')->join('product_details', 'product_details.id', '=', 'stores.productdetail_id')->where('product_details.product_id',$request->product_id)->where('stores.isdelete',false)->where('product_details.size',$request->size)->get();
            }
            foreach ($quantities as $key => $value) {
                $quantity += $value->quantity;
            }
            return Response($quantity);
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
    // Contact us
    public function contact()
    {
        $abouts = About::take(1)->get(); 
        return view('user.home.contact',compact('abouts'));
    }
    public function sendContact(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'   => 'required',
            'message'   => 'required'
        ]);

        $email = $request->email;

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->message
        );
        Mail::send('user.home.mail',$data, function($message) use ($data){
            //form
            //to
            $message->to("caber9998@gmail.com");
            //subject
            // $message->subject($data['name']);
            $message->subject("Contact from customer");
        });
        Session::flash('message', 'Send message successfully!');

        return redirect('/contact');
    }
    // End Contact us
    public function about()
    {
        $abouts = About::take(1)->get(); 
        return view('user.home.about',compact('abouts'));
    }
    public function topVote()
    {  
        $product_ids =Comment::select('product_id')->where('isdelete',false)->where('isdisplay',true)->distinct()->get(); 
        $stars = array(); 
        foreach ($product_ids as $key => $id) {
            $star = Comment::where('isdelete',false)->where('isdisplay',true)->where('product_id',$id->product_id)->sum('star');
            $quantity = Comment::where('isdelete',false)->where('isdisplay',true)->where('product_id',$id->product_id)->count();
            $stars += array($id->product_id => round($star/$quantity));  
        } 
        arsort($stars);
        return $stars;
    }
}

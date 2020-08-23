<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Image;
use App\Models\User;
use App\Models\Order;
use App\Models\Product_Detail;
use DB;
use Auth;
use Response;

class HomeController extends Controller
{
    // Kiem tra xac thuc khi admin chua dang nhap
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $product = Product::count();
        $productsale = Product::where('promotion','<>','0')->count();
        $category = Category::count();
        $brand = Brand::count();
        $order = Order::count();
        $user = User::where('level',2)->count();
        $order_take = Order::orderBy('created_at', 'desc')->where('status','unconfimred')->get();
        $orders = Order::all();
        return view('admin.home.home',compact('product','category','brand','order','user','productsale','order_take','orders'));
    }
}

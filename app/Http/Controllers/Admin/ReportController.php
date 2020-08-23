<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Order; 
use App\Models\Product; 
use App\Models\Store;
use App\Models\Brand;
use App\Models\User;
use App\Models\Product_Detail; 
use App\Models\Category; 
use App\Models\Order_detail;
use Carbon\Carbon;
use DB;
use Auth;
use Response;

class ReportController extends Controller
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
        $product = Product::count();
        $productsale = Product::where('promotion','<>','0')->count();
        $category = Category::count();
        $brand = Brand::count();
        $order = Order::count();
        $user = User::where('level',2)->count();
        $order_take = Order::orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        $orders = Order::all();
        $year_have_order = $orders->unique(function($item){
            return $item['created_at']->year;
        })->map(function($item){
            return $item['created_at']->year;
        })->sort()->toArray();
        $arr_year = $year_have_order;
        $year_now = date("Y");
        return view('admin.report.byrevenue',compact('product','category','brand','order','user','productsale','order_take','arr_year','year_now'));
    }
    public function chartTotalmonth(Request $request)
    {
        $array = array();
        for ($i=1; $i<=12 ; $i++) { 
            $arrTotal = array();
            $orderInMonth =  DB::table('orders')
            ->whereMonth('created_at', $i)->whereYear('created_at', $request->year)
            ->get();
            foreach ($orderInMonth as $key) {
                $arrTotal[] =  $key->total_amount;
            }            
            $array[] = array_sum($arrTotal);
        }
        return Response::json($array);
    }
    public function chartTotalYear()
    {
        $orders = Order::all();
        $year_have_order = $orders->unique(function($item)
        {
            return $item['created_at']->year;
                })->map(function($item){
                    return $item['created_at']->year;
                })->sort()->toArray();
                $total =array();
                foreach ($year_have_order as $key) {
                    $arr_year[] = $key; 
                    $orderByYear = DB::table('orders')->whereYear('created_at', $key)->get();
                    $arrTotal = array();
                    foreach ($orderByYear as $o) {
                       $arrTotal[] =  $o->total_amount;
                   } 
                   $sum = array_sum($arrTotal);
                   $total[] = $sum;
       }
        $result = [$arr_year,$total];
       return Response::json($result);
    }
    public function byOrder(Request $request)
    {  
        $year = strftime("%Y", time());
        if ($request->year) {
            $year = $request->year;
        }
        $orderYear = $this->orderByYear();
        $orderMonth = $this->orderByMonth($year);
        $orders = Order::orderBy('created_at');
        if ($request->from) { 
            $from = date("Y-m-d", strtotime($request->from));
            $orders = $orders->where('transaction_date','>=',$from);
        }
        if ($request->to) { 
            $to = date("Y-m-d", strtotime($request->to));
            $orders = $orders->where('transaction_date','<=',$to);
        }
        $total_amount = $orders->sum('total_amount');
        $orders = $orders->get(); 
        $unconfimred = 0;
        $confimred = 0;
        $delivery = 0;
        $delivered = 0;
        $cancel = 0;
        foreach ($orders as $key => $value) {
            switch ($value->status) {
                case 'unconfimred':
                    $unconfimred++;
                    break;
                case 'confimred':
                    $confimred++;
                    break;
                case 'delivery':
                    $delivery++;
                    break;
                case 'delivered':
                    $delivered++;
                    break; 
                case 'cancel':
                    $cancel++;
                    break;           
                default:
                    break;
            }
        }
        return view('admin.report.byorder', compact('orderMonth','orderYear','unconfimred','confimred','delivery','delivered','cancel','total_amount')); 
    } 
    public function byProduct(Request $request)
    {
        $products_id = product::select('id')->where('isdelete',false)->get();  
        $quantity_sell = array();
        $quantity_remaining = array(); 
        $from = '0000-00-00';
        $to = date("Y-m-d", time());
        $total_amount = 0;
        if ($request->from) {
            $from = date("Y-m-d", strtotime($request->from));
        }   
        if ($request->to) {
            $to = date("Y-m-d", strtotime($request->to));
        }
        foreach ($products_id as $key => $product) {
            $product_detail = Product_Detail::select('id')->where('product_id',$product->id)->pluck('id')->toArray(); 
            $total_amount += $this->getQuantitySell($product_detail,$from,$to); 
            $quantity_sell += array($product->id => $this->getQuantitySell($product_detail,$from,$to));
        }
        arsort($quantity_sell);
        $products = array();
        foreach ($quantity_sell as $key => $value) {
            $product_detail = Product_Detail::select('id')->where('product_id',$key)->pluck('id')->toArray(); 
            $quantity_remaining[] = $this->getQuantityRemaining($product_detail); 
            $product = Product::findOrfail($key);
            array_push($products,$product); 
        }
        return view('admin.report.byproduct',compact('products','quantity_sell','quantity_remaining','total_amount'));
    }
    public function orderByYear()
    {
        $year = strftime("%Y", time());
        $orderYear = DB::table('orders')
                    ->select(DB::raw('year(transaction_date) as getYear'), DB::raw('COUNT(*) as value'))
                    ->where('transaction_date', '>=', $year)
                    ->groupBy('getYear')
                    ->orderBy('getYear', 'ASC')
                    ->get();
        return $orderYear;
    }
    public function orderByMonth($year)
    { 
        $orderMonth = DB::table('orders')
                    ->select(DB::raw('month(transaction_date) as getMonth'), DB::raw('COUNT(*) as value'))
                    ->whereYear('transaction_date',$year)
                    ->groupBy('getMonth')
                    ->orderBy('getMonth', 'ASC')
                    ->get();
        return $orderMonth;
    }
    public function getQuantitySell($product_detail_id,$from,$to)
    { 
        $quantity_sell = DB::table('order_details')
                        ->select(DB::raw('SUM(order_details.quantity) as total_quantity'))  
                        ->join('orders','order_details.order_id','orders.id')
                        ->where('transaction_date','>=',$from)
                        ->where('transaction_date','<=',$to)
                        ->whereIn('order_details.product_detail_id',$product_detail_id)
                        ->groupBy('order_details.product_detail_id') 
                        ->pluck('total_quantity')
                        ->toArray();
        return array_sum($quantity_sell);
    }
    public function getQuantityRemaining($product_detail_id)
    { 
        $quantity_remaining = DB::table('stores')
                        ->select(DB::raw('SUM(quantity) as total_quantity'))  
                        ->whereIn('productdetail_id',$product_detail_id)
                        ->groupBy('productdetail_id') 
                        ->pluck('total_quantity')
                        ->toArray();
        return array_sum($quantity_remaining);
    }
}
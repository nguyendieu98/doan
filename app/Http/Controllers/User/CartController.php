<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\About;
use App\Models\Product_Detail;
use App\Models\Store;
use App\Models\Order;
use App\Models\Order_detail;
use Carbon\Carbon;
use App\User;
use Auth;
use App\Http\Requests\PlaceorderRequest;

class CartController extends Controller
{
    // Kiem tra xac thuc khi client chua dang nhap
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abouts = About::take(1)->get(); 
        return view('user.cart.cart',compact('abouts'));
    }

    public function addToCart(Request $request,$id)
    {
        $productdetail_id = Product_Detail::select('id')->where('isdelete',false)->where('product_id',$id)->where('size',$request->size)->where('color',$request->color)->first();
        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        if ($product->promotion) {
            $price = $product->price - $product->price * $product->promotion/100;
        }else{
            $price = $product->price;
        }
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                $productdetail_id->id => [
                    "id" => $productdetail_id->id,
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "quantity" => $request->quantity,
                    "price" => $price,
                    "image" => $product->image,
                    "size" => $request->size,
                    "color" => $request->color
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$productdetail_id->id])) {
            $cart[$productdetail_id->id]['quantity'] += $request->quantity;
            $quantity = Store::select('quantity')->where('isdelete',false)->where('productdetail_id',$productdetail_id->id)->first();
            if ($cart[$productdetail_id->id]['quantity'] > $quantity->quantity) {
                $cart[$productdetail_id->id]['quantity'] = $quantity->quantity;
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
        // if item not exist in cart then add to cart
        $cart[$productdetail_id->id] = [
            "id" => $productdetail_id->id,
            "name" => $product->name,
            "slug" => $product->slug,
            "quantity" => $request->quantity,
            "price" => $price,
            "image" => $product->image,
            "size" => $request->size,
            "color" => $request->color
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function update(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $quantity = Store::select('quantity')->where('isdelete',false)->where('productdetail_id',$request->id)->first();
            if ($request->quantity > $quantity->quantity) {
                session()->flash('err', 'Quantity less than '.$quantity->quantity);
            }else{
                $cart = session()->get('cart');
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                session()->flash('success', 'Cart updated successfully');
            } 
        }
    }
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
    public function checkout(Request $request)
    {
        $abouts = About::take(1)->get();
        return view('user.cart.checkout',compact('abouts'));
    }
    public function placeorder(Request $request)
    { 
        $isquantity = true;
        foreach ($request->product_detail_id as $key => $value) {
            if (!$this->checkQuantity($value,$request->quantity[$key])) {
                $cart = session()->get('cart');
                unset($cart[$value]);
                session()->put('cart', $cart);
                $isquantity = false;
            }
        }
        if (!$isquantity) {
            return redirect('/cart')->with('err', 'Product quantity not enough!');  
        }
        $user = Auth::guard('client')->user();
        $userinfo = User::findOrFail($user->id);
        $userinfo->first_name = $request->first_name;
        $userinfo->last_name = $request->last_name;
        $userinfo->address = $request->address;
        $userinfo->phone = $request->phone;
        $userinfo->update();
        $status = 'unconfimred';
        if ($request->payment != 'cod') {
            $status = 'cancel';
        }
        $order = new Order([
            'order_code' => uniqid(),
            'total_amount' => $request->total_amount,
            'status' => $status,
            'payment' => $request->payment,
            'transaction_date' => Carbon::now()->toDateTimeString(),
            'notes' => $request->notes,
            'user_id' => Auth::guard('client')->user()->id,
            'created_by' => Auth::guard('client')->user()->id,
            'updated_at' => null,
        ]);
        $order->save();
        foreach ($request->quantity as $key => $value) {
            $order_detail = new Order_detail([
                'quantity' => $value,
                'price' => $request->price[$key],
                'total_amount' => $request->price[$key] * $value,
                'order_id' => $order->id,
                'product_detail_id' => $request->product_detail_id[$key],
                'isfeedback' => false,
                'created_by' => Auth::guard('client')->user()->id,
                'updated_by' => null
            ]);
            $order_detail->save();
            if ($status == 'unconfimred') {
                $this->updateStore($order_detail->product_detail_id,$order_detail->quantity);
            }
        }    
        //VNPAY
        if ($request->payment == 'vnpay') { 
            $vnp_TmnCode = "2HULBQDO"; //Mã website tại VNPAY 
            $vnp_HashSecret = "CQBSBRQYSPMAZJSNTOUVNHGRBRFMUHLA"; //Chuỗi bí mật
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "http://myshop.vn/return-vnpay";
            $vnp_TxnRef = date("YmdHis").$order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = "Thanh toán hóa đơn ";
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $request->total_amount * 100;
            $vnp_Locale = 'vn';
            $vnp_IpAddr = request()->ip();
            $vnp_BankCode = $request->input('bank_code');
            $inputData = array(
                "vnp_Version" => "2.0.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            } 
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
               // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
                $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
                $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            } 
            return redirect($vnp_Url) ;
        } 
        //MoMo
        if ($request->payment == 'momo'){
            $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
            $partnerCode = "MOMOBKUN20180529";
            $accessKey = "klm05TvNBzhg7h7j";
            $serectkey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";
            $orderId = date("YmdHis").$order->id; // Mã đơn hàng
            $orderInfo = "Thanh toán qua MoMo";
            $amount = $request->total_amount;
            $notifyurl = "http://myshop.vn/cart";
            $returnUrl = "http://myshop.vn/return-vnpay";
            $extraData = "merchantName=MoMo Partner";
            $requestId = time() . "";
            $requestType = "captureMoMoWallet";
            $extraData = ($request->extraData ? $request->extraData : "");
            //before sign HMAC SHA256 signature
            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
            $signature = hash_hmac("sha256", $rawHash, $serectkey);
            $data = array('partnerCode' => $partnerCode,
                'accessKey' => $accessKey,
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'returnUrl' => $returnUrl,
                'notifyUrl' => $notifyurl,
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json
            return redirect($jsonResult['payUrl']);
        }  
        $request->session()->forget('cart');
        return redirect('/cart')->with('success', 'Order complete. Thanks you!');  
    }
    public function return(Request $request)
    {
        if($request->vnp_ResponseCode == "00") {
            $id = substr($request->vnp_TxnRef, (14-strlen($request->vnp_TxnRef))); 
            $order = Order::findOrFail($id);
            $order->status = "unconfimred";
            $order->updated_by = Auth::guard('client')->user()->id;
            $order->update(); 
            $order_details = Order_detail::select('product_detail_id','quantity')->where('order_id',$id)->get(); 
            foreach ($order_details as $key => $order_detail) {
                $this->updateStore($order_detail->product_detail_id,$order_detail->quantity);
            }
            $request->session()->forget('cart');
            return redirect('/cart')->with('success' ,'Payment success. Thanks you!');
        }
        if ($request->errorCode == "0") {
            $id = substr($request->orderId, (14-strlen($request->orderId)));
            $order = Order::findOrFail($id);
            $order->status = "unconfimred";
            $order->updated_by = Auth::guard('client')->user()->id;
            $order->update(); 
            $order_details = Order_detail::select('product_detail_id','quantity')->where('order_id',$id)->get();  
            foreach ($order_details as $key => $order_detail) {
                $this->updateStore($order_detail->product_detail_id,$order_detail->quantity);
            }
            $request->session()->forget('cart');
            return redirect('/cart')->with('success' ,'Payment success. Thanks you!');
        }  
        return redirect('/cart');
    }
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }  
    public function updateStore($product_detail_id,$quantity)
    {
        $store = Store::where('productdetail_id',$product_detail_id)->first();  
        $store->quantity -= $quantity;
        $store->update();       
   } 
   public function checkQuantity($product_detail_id,$quantity)
    {
        $store = Store::where('productdetail_id',$product_detail_id)->first(); 
        if ($store->quantity < $quantity) {
            return false;
        }
        return true;
    }  
}
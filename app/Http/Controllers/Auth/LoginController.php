<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Product;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout', 'adminLogout');
        $this->middleware('guest:client')->except('logout', 'clientLogout');
    }

    public function showAdminLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return back();
        }
        return view('admin.auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password, 'level' => 1, 'isdelete' => false], $request->get('remember'))) {

            return redirect()->intended('/admin/home');
        }
        Session::flash('err','Username or Password incorrect!');
        return back()->withInput($request->only('username', 'remember'))->with('err','Username or Password incorrect!');
    }

    public function showClientLoginForm()
    {
        $abouts = About::take(1)->get(); 
        if (Auth::guard('client')->check()) {
            return back();
        }
        return view('user.auth.login', ['url' => 'client'],compact('abouts'));
    }

    public function clientLogin(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('client')->attempt(['username' => $request->username, 'password' => $request->password, 'level' => 2, 'isdelete' => false], $request->get('remember'))) {   
            //Kiem tra url truoc do co phai POST add-to-cart k?
            $start = strpos($request->session()->get('url.intended'),'add-to-cart');
            if ($start) {
                //GET id product 
                $end = strpos($request->session()->get('url.intended'),'?');
                $id = substr($request->session()->get('url.intended'), $start+12,$end-$start-12);
                $product = Product::findOrfail($id);
                return redirect('products/'.$product->name);
            } 
            return redirect()->intended('/');
        }
        Session::flash('err','Username or Password incorrect!');
        return back()->withInput($request->only('username', 'remember'))->with('err','Username or Password incorrect!');
    }

    // Dang xuat Admin
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    // Dang xuat Client
    public function clientLogout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->forget('cart');
        //$request->session()->flush();
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->middleware('guest:admin');
        $this->middleware('guest:client');
    }

    public function showAdminRegisterForm()
    {
        return view('admin.auth.register', ['url' => 'admin']);
    }

    public function showClientRegisterForm()
    {
        return view('user.auth.register', ['url' => 'client']);
    }

    // validator
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|size:10',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|same:confirm_password',
            'confirm_password' => 'required',
        ]);
    }

    // Admin ko co register de tam day test thu
    protected function createAdmin(Request $request)
    {
        $this->validator($request->all())->validate(); 
        $admin = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'username' => $request['username'],
            'level' => 1,
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'confirm_password' => bcrypt($request['confirm_password']),
            'isdelete' => false,
            'updated_at' => null
        ]);
        $admin->role()->attach($request->role_id);
        return redirect()->intended('/admin/user');
    }

    // Register Client
    protected function createClient(Request $request)
    {
        $this->validator($request->all())->validate();
        $writer = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'username' => $request['username'],
            'level' => 2,
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'confirm_password' => bcrypt($request['confirm_password']),
            'isdelete' => false,
            'updated_at' => null
        ]);
        return redirect('/login');
    }

}

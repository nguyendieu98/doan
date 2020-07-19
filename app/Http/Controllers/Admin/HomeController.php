<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;

class HomeController extends Controller
{
	// Kiem tra xac thuc khi admin chua dang nhap
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
	
    public function index()
    {
        return view('admin.home.home');
    }
}

@extends('user.layout.main')
@section('title','Register')
@section('content')
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12"> 
                <div class="breadcrumb-row">
                    <h3 class="breadcrumb"><a href="/" class="home">Home</a><span>/</span>Register</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="card user_register">
                <div class="card-header">
                    <h2 class="">Register</h2>
                </div>
                <div class="line_green"></div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/register') }}">
                        @csrf
                        <div class="form-group"> 
                            <label class="control-label">First name</label>              
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First name" autofocus>
                            <strong class="text-danger">{{ $errors->first('first_name')}}</strong> 
                        </div>
                        <div class="form-group">  
                            <label class="control-label">Last name</label>
                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" autofocus>
                            <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Address" autofocus>
                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone</label>
                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Phone"  autofocus>
                            <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                        </div>
                        <div class="form-group">
                            <label class="control-label">User name</label>
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="User name"  autofocus>
                            <strong class="text-danger">{{ $errors->first('username') }}</strong>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" >
                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm password</label>
                            <input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="Confirm password" >
                            <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-success user_register_button">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
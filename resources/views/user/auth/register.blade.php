@extends('user.layout.main')
@section('title',__('validation.Register'))
@section('content')
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12"> 
                <div class="breadcrumb-row">
                   <h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span>{{__('validation.Register')}}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-offset-1">
            <div class="card">
                <div class="row card-header"><h2 class="text-center">{{__('validation.Register')}}</h2></div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/register') }}">
                        @csrf
                        <div class="col-md-6 form-group">
                            <div class="form-group ">    
                                <label for="">{{ __('regis.firstname') }}:</label>                        
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('regis.firstname') }}" autofocus>
                                <strong class="text-danger">{{ $errors->first('first_name')}}</strong> 
                            </div>
                            <div class="form-group ">        
                                <label for="">{{ __('regis.lastname') }}:</label>                     
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('regis.lastname') }}" autofocus>
                                <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                            </div>
                            <div class="form-group ">   
                                <label for="">{{ __('regis.Address') }}:</label>                          
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="{{ __('regis.Address') }}" autofocus>
                                <strong class="text-danger">{{ $errors->first('address') }}</strong>
                            </div>
                            <div class="form-group ">  
                                <label for="">{{ __('regis.Phone') }}:</label>                          
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="{{ __('regis.Phone') }}"  autofocus>
                                <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-group ">  
                                <label for="">{{ __('regis.user') }}:</label>                          
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="{{ __('regis.user') }}"  autofocus>
                                <strong class="text-danger">{{ $errors->first('username') }}</strong>
                            </div>
                            <div class="form-group ">
                                <label for="">{{ __('regis.Email') }}:</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ __('regis.Email') }}">
                                <strong class="text-danger">{{ $errors->first('email') }}</strong>
                            </div>
                            <div class="form-group "> 
                                <label for="">{{ __('regis.Pass') }}:</label>                           
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{ __('regis.Pass') }}" >
                                <strong class="text-danger">{{ $errors->first('password') }}</strong>
                            </div>
                            <div class="form-group ">    
                                <label for="">{{ __('regis.Passcf') }}:</label>                      
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password" placeholder="{{ __('regis.Passcf') }}" >
                                <strong class="text-danger">{{ $errors->first('confirm_password') }}</strong>
                            </div> 
                        </div> 
                        <div class="form-group col-md-12  mb-0">
                                <button type="submit" class="btn btn-success">
                                    {{ __('validation.Register') }}
                                </button>                            
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('user.layout.main')
@section('title',__('validation.Login'))
@section('content')
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{mb_strtoupper(__('client.Home'))}}</a><span>/</span>{{__('validation.Login')}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container">
	<div class="row">
		<div class="client_login_form col-sm-5 col-sm-offset-4">
			<div class="card-body">
				<form method="POST" action="{{ url('/login') }}">
					<div class="card-header"><h2 class="text-center">{{__('validation.Login')}}</h2></div>
					@csrf
					<div class="form-group">							
						<input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{__('log.username')}}" name="username" value="{{ old('username') }}" autofocus>
						<strong class="text-danger">{{ $errors->first('username') }}</strong>
					</div>
					<div class="form-group">
						<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{__('log.pass')}}" name="password" style="margin-bottom: 10px;">
						<strong class="text-danger">{{ $errors->first('password') }}</strong>
						@if (Session::has('err'))
						<span class="invalid-feedback text-danger"><strong>{{ Session::get('err')}}</strong></span>
						@endif
					</div>
					<div class="form-group">							
						<button type="submit" class="btn btn-success btn-block">{{__('validation.Login')}}</button>
						<p class="text-center" style="margin-top: 10px;"><a href="{{ url('/register') }}" >{{__('log.create')}}</a></p>
						@if (Route::has('password.request'))
						<p class="text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{__('log.forgotpw')}}
                            </a>
                        </p>
                        @endif
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@foreach($abouts as $key => $about)
<input type="hidden" value="{{$about->title}}" id="titlevalue">
<input type="hidden" value="{{$about->name}}" id="namevalue">
<input type="hidden" value="{{$about->address}}" id="addressvalue">
<input type="hidden" value="{{$about->email}}" id="emailvalue">
<input type="hidden" value="{{$about->phone}}" id="phonevalue">
<input type="hidden" value="{{asset('images/'.$about->logo)}}" id="logovalue">
@endforeach
@endsection
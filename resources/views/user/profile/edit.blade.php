@extends('user.layout.main')
@section('title',__('editprofile.edit1'))
@section('content') 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span><a href="{{ url('/profile') }}">{{__('profileUser.profile')}}</a><span>/</span>{{__('editprofile.edit1')}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container">
	<br>
	<div class="col-xs-12 col-sm-6 col-sm-offset-3 edit_user_info">
		<h3>{{__('editprofile.edit1')}}</h3>
		<div class="line_green"></div>
		{{Form::open(['route'=>['profile.update',$users->id],'method'=>'put'])}}
			<div class="form-group">  
				<label for="">{{__('profileUser.firstname')}}:</label>                          
		        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $users->first_name }}" placeholder="First name" autofocus>
		        <strong class="text-danger">{{ $errors->first('first_name')}}</strong> 
		    </div>
		    <div class="form-group">   
				<label for="">{{__('profileUser.lastname')}}:</label>                         
		        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $users->last_name }}" placeholder="Last name" autofocus>
		        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
		    </div>
		    <div class="form-group">  
				<label for="">{{__('profileUser.add')}}:</label>                          
		        <input id="address" type="text" class="form-control" name="address" value="{{ $users->address }}" placeholder="Address" autofocus>
		        <strong class="text-danger">{{ $errors->first('address') }}</strong>
		    </div>
		    <div class="form-group"> 
				<label for="">{{__('profileUser.phone')}}:</label>                           
		        <input id="phone" type="text" class="form-control" name="phone" value="{{ $users->phone }}" placeholder="Phone"  autofocus>
		        <strong class="text-danger">{{ $errors->first('phone') }}</strong>
		    </div>
		    <div class="form-group">
				<label for="">Email:</label>
		        <input id="email" type="email" class="form-control" name="email" value="{{ $users->email }}" placeholder="Email">
		        <strong class="text-danger">{{ $errors->first('email') }}</strong>
		    </div>
			<div class="form-group col-md-12">
				<div class="row">
					{{ Form::submit(__('editprofile.save'),['class'=>'btn btn-success']) }}
					<a href="{{ url('/profile') }}" class="btn btn-danger">{{__('editprofile.back')}}</a>
				</div>
			</div>
		{{ Form::close() }}
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
<script src="{{asset('client/js/setabout.js')}}"></script>
@endsection
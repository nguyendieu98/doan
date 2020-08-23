@extends('user.layout.main')
@section('title',__('client.Contact'))
@section('content') 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span>{{__('client.Contact')}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<!-- contact-area start -->
<div class="contact-area">
	<div class="container">
		<div class="row">
			<!-- contact-info start -->
			<div class="col-md-6 col-sm-12 col-xs-12 left-con">
				<div class="contact-info">
					<h3>{{__('client.contactinfo')}}</h3>
					<ul>
						<li>
							<i class="fa fa-map-marker"></i> <strong>{{__('profileUser.add')}} :</strong>
							{{$abouts[0]->address}}
						</li>
						<li>
							<i class="fa fa-mobile"></i> <strong>{{__('profileUser.phone')}} :</strong>
							{{$abouts[0]->phone}}
						</li>
						<li>
							<i class="fa fa-envelope"></i> <strong>Email:</strong>
							{{$abouts[0]->email}}
						</li>
					</ul>
				</div>
			</div>
			<!-- contact-info end -->
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="contact-form">
					<h3>{{__('client.LEAVEAMESSAGE')}}</h3>
					<div class="row">
						@if (Session::has('message'))
							<p class="alert alert-success notification">{{ Session::get('message')}}</p>
						@endif
						<form action="{{ url('/contact') }}" method="POST">
							@csrf
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input name="name" type="text" placeholder="Name (required)" />
								<strong class="text-danger">{{ $errors->first('name')}}</strong>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input name="email" type="email" placeholder="Email (required)" />
								<strong class="text-danger">{{ $errors->first('email')}}</strong>
							</div> 
							<div class="col-md-12 col-sm-12 col-xs-12">
								<textarea name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
								<strong class="text-danger">{{ $errors->first('message')}}</strong>
								
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<input type="submit" value="Send contact" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- contact-area end -->
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
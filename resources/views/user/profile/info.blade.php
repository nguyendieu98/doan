@extends('user.layout.main')
@section('title','Profile')
@section('content')
<style>
	/* Rating Star Widgets Style */ 
	.rating-stars ul {
		list-style-type:none;
		padding:0;
		-moz-user-select:none;
		-webkit-user-select:none;
	}
	.rating-stars ul > li.star {
		display:inline-block;  
	}
	/* Idle State of the stars */
	.rating-stars ul > li.star > i.fa {
		font-size:1em; /* Change the size of the stars */
		color:#ccc; /* Color on idle state */
	} 
	/* Hover state of the stars */
	.rating-stars ul > li.star.hover > i.fa {
		color:#FFCC36;
	} 
	/* Selected state of the stars */
	.rating-stars ul > li.star.selected > i.fa {
		color:#FF912C;
	} 
</style>
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">Home</a><span>/</span>Profile</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container">
	<div class="row">
		<!-- Khu vuc thong tin khach hang -->
		<div class="col-xs-12 col-sm-3 info_user">
			<div class="info_user_inner">
				<h2 class="text-center line_green_center">Profile</h2>
				<h4>First name</h4>
				<h6>{{ Auth::guard('client')->user()->first_name }}</h6>
				<hr>	
				<h4>Last name</h4>
				<h6 >{{ Auth::guard('client')->user()->last_name }}</h6>
				<hr>
				<h4>Address</h4>
				<h6 >{{ Auth::guard('client')->user()->address }}</h6>
				<hr>
				<h4>Phone </h4>
				<h6 >{{ Auth::guard('client')->user()->phone }}</h6>
				<hr>
				<h4>Email </h4>
				<h6>{{ Auth::guard('client')->user()->email }}</h6>
			</div>			
			<div class="text-center">
				<a href="{{route('profile.editprofile',Auth::guard('client')->user()->username)}}" class="btn btn-success">Edit Profile</a>
				<a href="{{ url('/changepassword') }}" class="btn btn-primary">Change Password</a>
			</div>
		</div>
		<!-- End Khu vuc thong tin khach hang -->
		<!-- Khu vuc xu ly thanh toan -->
		<div class="col-xs-12 col-sm-9" style="background: #f5f5f5;"> 
			<ul class="nav nav-tabs orderstatus">
				<li class="active ">
					<a class="h4 " href="{{url('/profile')}}" style="margin: 0;">All Order (<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[0]}}</span>)</a>
				</li>
				<li class="unconfimred">
					<a class="h4" href="{{url('/profile')}}?status=unconfimred" style="color: #444;margin: 0;">Unconfimred (<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[1]}}</span>)</a>
				</li>
				<li class="delivery">
					<a class="h4" href="{{url('/profile')}}?status=delivery" style="color: #444;margin: 0;">Delivery (<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[2]}}</span>)</a>
				</li> 
				<li class="delivered">
					<a class="h4" href="{{url('/profile')}}?status=delivered" style="color: #444;margin: 0;">Delivered (<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[3]}}</span>)</a>
				</li> 
				<li class="cancel">
					<a class="h4" href="{{url('/profile')}}?status=cancel" style="color: #444;margin: 0;">Cancel (<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[4]}}</span>)</a>
				</li> 
			</ul>
			<br>
			@foreach($orders as $key => $order)
			<div class="card col-md-12 bg-light" style="margin-bottom: 15px; background: white;border-radius: 4px;">
				<div class="row no-gutters" style="margin: 10px 0px;">
					<a href="{{ url('order/'.$order->order_code) }}">
						<div class="col-xs-2 col-md-2">
							<img src="{{asset('images/'.$order->order_detail[0]->product_detail->product->image)}}" class="card-img" style="width: 100%; height: 90px;">
						</div>
						<div class="col-xs-7 col-md-7">
							<div class="card-body">
								@foreach($order->order_detail as $key => $value)
								<p>{{$value->product_detail->product->name}} ({{$value->product_detail->size}} {{$value->product_detail->color}} x {{$value->quantity}})</p>
								<input type="hidden" value="{{$value->product_detail->product->id}}" class="productid{{$order->id}}[]"> 
								@endforeach 
								<p class="card-text"><small class="text-muted">{{$order->transaction_date}}</small></p>
							</div>
						</div>
					</a>
					<div class="col-xs-3 col-md-3">
						<p>{{strtoupper($order->status)}}</p>
						<p>Total amount: <span style="color: green; font-size: 20px;">{{$order->total_amount}}đ</span></p> 
						<a href="{{ url('order/'.$order->order_code) }}" class="btn btn-success col-xs-12 col-md-5" style="margin-right: 10px;">Detail</a>
						<form action="{{ url('/received') }}" method="POST">
							@csrf
							<input type="hidden" name="order_id" value="{{$order->id}}">
							@if($order->status == 'delivery')
							<input type="submit" value="Received" class="btn btn-light col-xs-12 col-md-5" style="border: 1px solid gray; padding-left: 10px;">
							@endif 
						</form>	
					</div>
				</div>
			</div>
			@endforeach  
		</div>
		<!-- End khu vuc xu ly thanh toan -->
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
<script>
	$('.feedbackproduct').click(function(){ 
		product = []; 
		var productid = document.getElementsByClassName("productid"+$(this).val()+"[]"); 
		for (var i = 0; i < productid.length; i++) {
			product.push(productid[i].value); 
		}
		//Loai bo phan tu trung trong mang
		product = product.filter((item, index) => product.indexOf(item) === index); 
		$('.contentbody').html(content);  
	});
	@if(isset($_GET['status'])) 
		@switch($_GET['status'])
		    @case('unconfimred')
		        $(".orderstatus li").removeClass("active");
				$("li.unconfimred").addClass("active");
		        @break 
		    @case('delivery')
		        $(".orderstatus li").removeClass("active");
				$("li.delivery").addClass("active");
		        @break
		    @case('delivered')
		        $(".orderstatus li").removeClass("active");
				$("li.delivered").addClass("active");
		        @break
		    @case('cancel')
		        $(".orderstatus li").removeClass("active");
				$("li.cancel").addClass("active");
		        @break    
		    @default 
		@endswitch
	@endif
	$(document).ready(function(){
		/* 1. Visualizing things on Hover - See next part for action on click */
		$('#stars li').on('mouseover', function(){ 
    		var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on 
    		// Now highlight all the stars that's not after the current hovered star
    		$(this).parent().children('li.star').each(function(e){
    			if (e < onStar) {
    				$(this).addClass('hover');
    			}
    			else {
    				$(this).removeClass('hover');
    			}
    		}); 
    	}).on('mouseout', function(){
    		$(this).parent().children('li.star').each(function(e){
    			$(this).removeClass('hover');
    		});
    	});
    	/* 2. Action to perform on click */
    	$('#stars li').on('click', function(){ 
	    	var onStar = parseInt($(this).data('value'), 10); // The star currently selected
	    	var stars = $(this).parent().children('li.star'); 
	    	for (i = 0; i < stars.length; i++) {
	    		$(stars[i]).removeClass('selected');
	    	}
	    	for (i = 0; i < onStar; i++) {
	    		$(stars[i]).addClass('selected');
	    	} 
	    	$(".starvalue").val($(this).data('value'));
	    }); 
    }); 	
</script>

@endsection
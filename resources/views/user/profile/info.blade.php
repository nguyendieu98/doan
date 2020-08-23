	@extends('user.layout.main')
@section('title',__('profileUser.profile'))
@section('content') 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span>{{mb_strtoupper(__('profileUser.profile'), 'UTF-8')}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<div class="container-fluid contentinfo">
	<div class="row">
		<!-- Khu vuc thong tin khach hang -->
		<div class="col-md-1"></div>
		<div class="col-xs-12 col-sm-3 info_user">
			<div class="info_user_inner">
				<h2 class="text-center " style="margin: 0;">{{__('profileUser.profile')}}</h2>
				<hr style="height: 1px;background: green;">
				@if (session('message'))
				<div class="alert alert-success notification">
					{{ session('message') }}
				</div>
				@endif  
				<h4>{{__('profileUser.firstname')}}:</h4>
				<h6>{{ Auth::guard('client')->user()->first_name }}</h6>
				<hr>	
				<h4>{{__('profileUser.lastname')}}:</h4>
				<h6 >{{ Auth::guard('client')->user()->last_name }}</h6>
				<hr>
				<h4>{{__('profileUser.add')}}:</h4>
				<h6 >{{ Auth::guard('client')->user()->address }}</h6>
				<hr>
				<h4>{{__('profileUser.phone')}}:</h4>
				<h6 >{{ Auth::guard('client')->user()->phone }}</h6>
				<hr>
				<h4>Email </h4>
				<h6>{{ Auth::guard('client')->user()->email }}</h6>
			</div>			
			<div class="text-center">
				<a href="{{route('profile.edit',Auth::guard('client')->user()->username)}}" class="btn btn-success col-md-12" style="margin-bottom: 10px;">{{__('profileUser.edit')}}</a>
				<a href="{{ url('/changepassword') }}">{{__('profileUser.editpass')}}</a>
			</div>
		</div>
		<div class="col-xs-12 col-sm-8" style="background: #f5f5f5;"> 
			<ul class="nav nav-tabs orderstatus">
				<li class="active">
					<a class="h4 " href="{{url('/profile')}}" style="margin: 0;">{{__('profileUser.allorder')}}(<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[0]}}</span>)</a>
				</li>
				<li class="unconfimred">
					<a class="h4" href="{{url('/profile')}}?status=unconfimred" style="color: #444;margin: 0;">{{__('profileUser.uncomf')}}(<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[1]}}</span>)</a>
				</li>
				<li class="confimred">
					<a class="h4" href="{{url('/profile')}}?status=confimred" style="color: #444;margin: 0;">{{__('profileUser.comfim')}}(<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[2]}}</span>)</a>
				</li>
				<li class="delivery">
					<a class="h4" href="{{url('/profile')}}?status=delivery" style="color: #444;margin: 0;">{{__('profileUser.delivery')}}(<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[3]}}</span>)</a>
				</li> 
				<li class="delivered">
					<a class="h4" href="{{url('/profile')}}?status=delivered" style="color: #444;margin: 0;">{{__('profileUser.delivered')}}(<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[4]}}</span>)</a>
				</li> 
				<li class="cancel">
					<a class="h4" href="{{url('/profile')}}?status=cancel" style="color: #444;margin: 0;">{{__('profileUser.cancel')}}(<span class="text-danger" style="font-size: 15px; font-weight: bold;">{{$quantity[5]}}</span>)</a>
				</li> 
			</ul>
			<br>
			@foreach($orders as $key => $order)
			<div class="card col-md-12 bg-light" style="margin-bottom: 15px; background: white;border-radius: 4px;">
				<div class="row no-gutters" style="margin: 10px 0px;">
					<a href="{{ url('order/'.$order->order_code) }}">
						<div class="col-xs-2 col-md-2">
							@foreach($order->order_detail as $key => $value)
							<img src="{{asset('images/'.$order->order_detail[0]->product_detail->product->image)}}" class="card-img" style="width: 100%; height: 90px;">
							@break
							@endforeach 
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
						@switch($order->status)
						@case('unconfimred')
						<p>{{mb_strtoupper(__('profileUser.uncomf'),'UTF-8')}}</p>
						@break 
						@case('confimred')
						<p>{{mb_strtoupper(__('profileUser.comfim'),'UTF-8')}}</p>
						@break
						@case('cancel')
						<p>{{mb_strtoupper(__('profileUser.cancel'),'UTF-8')}}</p>
						@break
						@case('delivery')
						<p>{{mb_strtoupper(__('profileUser.delivery'),'UTF-8')}}</p>
						@break
						@case('delivered')
						<p>{{mb_strtoupper(__('profileUser.delivered'),'UTF-8')}}</p>
						@break          
						@default

						@endswitch
						<p>{{__('profileUser.totalamount')}}:<span style="color: green; font-size: 18px;">{{number_format($order->total_amount)}}đ</span></p> 
						<a href="{{ url('order/'.$order->order_code) }}" class="btn btn-sm btn-success col-xs-12 col-md-5" style="margin-right: 10px; margin-top: 5px;">{{__('profileUser.detail')}}</a>
						@if($order->status == 'delivery')
						<form action="{{ url('/received') }}" method="POST">
							@csrf
							<input type="hidden" name="order_id" value="{{$order->id}}"> 
							<input type="submit" value="Received" class="btn btn-light btn-sm col-xs-12 col-md-5" style="border: 1px solid gray; padding-left: 10px; margin-top: 5px;"> 
						</form>	
						@endif
						@if($order->status == 'unconfimred')
						<form action="{{ url('/cancelorder') }}" method="POST" id="formcancel">
							@csrf
							<input type="hidden" name="order_id" value="{{$order->id}}"> 
							<input type="button" value="{{__('profileUser.cancel')}}" id="cancel"   class="btn btn-danger btn-sm  col-xs-12 col-md-5" style="border: 1px solid gray; padding-left: 10px; margin-top: 5px;"> 
						</form>	
						@endif
					</div>
				</div>
			</div>
			@endforeach  
			<!-- paginate -->
				<div class="">
					{{$orders->links()}}	
				</div>
		</div> 
		<!-- Khu vuc thanh toan -->
		<div class="col-xs-12 col-sm-9">
			<!-- Thanh Header trang thai --> 
			<!-- Khu vuc hien thi --> 
		</div>
	</div>
</div> 
<!-- Modal Cancel-->
<div class="modal fade" id="modalcancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">{{__('profileUser.Cancelthisorder')}}</h4> 
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('profileUser.no')}}</button>
        <button type="button" class="btn btn-danger yescancel">{{__('profileUser.yes')}}</button>
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
	$('#cancel').click(function(){ 
		$('#modalcancel').modal('show'); 
		$("#bodycontent").css({"padding-right": "0px" }); 
		$('.yescancel').click(function(){  
			document.getElementById("formcancel").submit();
		}); 
	});
	@if(isset($_GET['status'])) 
	@switch($_GET['status'])
	@case('unconfimred')
	$(".orderstatus li").removeClass("active");
	$("li.unconfimred").addClass("active");
	@break 
	@case('confimred')
	$(".orderstatus li").removeClass("active");
	$("li.confimred").addClass("active");
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
@extends('user.layout.main')
@section('title','Orderdetail')
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
					<h3 class="breadcrumb"><a href="/" class="home">Home</a><span>/</span><a href="{{url('/profile')}}" class="home">Profle</a><span>/</span>Order Detail</h3>
				</div>
			</div>
		</div>
	</div>
</div> 
<div class="container">
	@foreach($order_details as $key => $order_detail)
	<div class="card col-md-12 bg-light" style="margin-bottom: 15px; background: white;border-radius: 4px;">
		<div class="row no-gutters" style="margin: 10px 0px;"> 
			<div class="col-xs-2 col-md-2">
				<a href="{{route('products.show',$order_detail->product_detail->product->slug)}}"><img src="{{asset('images/'.$order_detail->product_detail->product->image)}}" class="card-img" style="width: 100%; height: 90px;"></a>
			</div>
			<div class="col-xs-7 col-md-7">
				<div class="card-body">
					<p><a href="{{route('products.show',$order_detail->product_detail->product->slug)}}">{{$order_detail->product_detail->product->name}} ({{$order_detail->product_detail->size}} {{$order_detail->product_detail->color}})</a></p>  
					<p>Quantity: {{$order_detail->quantity}} </p>
					<p>Price: {{$order_detail->product_detail->product->price}} </p>
				</div>
			</div> 
			<div class="col-xs-3 col-md-3">
				<p>{{strtoupper($order_detail->order->status)}}</p>   
				<p> <span style="color: green; font-size: 20px;">{{$order_detail->quantity * $order_detail->product_detail->product->price}}đ</span></p> 
				@if(!$order_detail->isfeedback && $order->status == 'delivered')
				<input type="hidden" class="product{{$order_detail->id}}" value="{{$order_detail->product_detail->product->id}}">
				<button class="feedbackproduct btn btn-success col-md-5" data-toggle="modal" data-target="#feedback" value="{{$order_detail->id}}">Feedback</button> 
				@endif 
			</div>
		</div>
	</div>
	@endforeach
	<div class="cart_totals"> 
		<div class="total_table">
			<table class="table-responsive">
				<tbody>
					<tr class="cart-subtotal">
						<th>Transaction date</th>
						<td><span class="amount">{{$order_details[0]->order->transaction_date}}</span></td>
					</tr>
					<tr class="cart-subtotal">
						<th>Subtotal</th>
						<td><span class="amount">{{$order_details[0]->order->total_amount}}đ</span></td>
					</tr>
					<tr class="shipping">
						<th>Shipping</th>
						<td>Free Shipping</td>
					</tr>
					<tr class="order-total">
						<th>Total</th>
						<td><strong><span class="amount"> {{$order_details[0]->order->total_amount}}đ</span></strong> </td>
					</tr>
				</tbody>
			</table> 
		</div>
	</div>
</div>
<div class="modal fade" id="feedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Feedback</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{url('comment')}}" method="POST">
				@csrf
				<div class="modal-body contentbody">
					<div class="form-group row">
						<div class="col-md-1">
							<input type="hidden" name="product_id" id="product_id">
							<input type="hidden" name="order_detail_id" id="order_detail_id">
						</div>
						<div class="col-md-4">
							<div class="rating-stars">
								<h4>Star voting:</h4>
								<ul id="stars" style="font-size: 25px;">
									<li class="star" title="Poor" data-value="1" id="1">
										<i class="fa fa-star fa-fw"></i>
									</li>
									<li class="star" title="Fair" data-value="2" id="2">
										<i class="fa fa-star fa-fw"></i>
									</li>
									<li class="star" title="Good" data-value="3" id="3">
										<i class="fa fa-star fa-fw"></i>
									</li>
									<li class="star" title="Excellent" data-value="4" id="4"><i class="fa fa-star fa-fw"></i>
									</li>
									<li class="star" title="WOW!!!" data-value="5" id="5">
										<i class="fa fa-star fa-fw"></i>
									</li>
								</ul>
								<input type="hidden" class="starvalue" name="star">
							</div> 
						</div>
						<div class="col-md-6">
							<h4>Comment:</h4>
							<textarea  cols="60" rows="10" class="comment" name="comment"></textarea>
						</div>
					</div>
				</div> 
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-success">Save changes</button>
				</div>
			</form>
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
			$('.star').removeClass('selected');
			$('.comment').val(''); 
			$("#product_id").val($(".product"+$(this).val()).val());
			$("#order_detail_id").val($(this).val());
		});
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
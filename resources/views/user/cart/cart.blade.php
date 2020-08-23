@extends('user.layout.main')
@section('title',__('cart.ShoppingCart'))
@section('content') 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span>{{__('cart.ShoppingCart')}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<!--page-checkout AREA START -->
<div class="page-checkout_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="checkout-breadcrumb"> 
					<div class="title-cart">
						<span>1</span>
						<p>{{__('cart.ShoppingCart')}}</p>
					</div> 
					<div class="title-checkout">
						<span>2</span>
						<p>{{__('cart.Checkoutdetails')}}</p>
					</div>
					<div class="title-thankyou">
						<span>3</span>
						<p>{{__('cart.OrderComplete')}}</p>
					</div>
				</div>
				<div class="cart-wrapper table-responsive">
					@if(session('success'))
					<div class="alert alert-success notification">
						{{ session('success') }}
					</div>
					@elseif(Session::has('err')) 
					<div class="alert alert-danger notification">
						{{ session('err') }}
					</div>
					@endif
					<table class="shop_table cart ">
						<thead>
							<tr>
								<th colspan="3" class="product-name">{{__('cart.product')}}</th>
								<th class="product-price">{{__('cart.price')}}</th>
								<th class="product-quantity">{{__('cart.quantity')}}</th>
								<th class="product-subtotal">{{__('cart.total')}}</th>
							</tr>
						</thead>
						<tbody>
							<?php $total = 0 ?>
							@if(session('cart'))
							@foreach(session('cart') as $id => $details)
							<?php $total += $details['price'] * $details['quantity'] ?>
							<tr class="cart_item">
								<td class="remove-product col-md-1">
									<button class="btn btn-danger btn-sm remove-from-cart" value="{{ $details['id'] }}" data-toggle="modal" data-target="#exampleModal"><span class="icon-close"></span></button> 
								</td>
								<td class=" col-md-3">
									<?php  $image = explode(',',$details['image']);	?>
									<div class="row">
										<div class="col-md-7">
											<a href="{{route('products.show',$details['slug'])}}"><img  alt="04" class="" src="{{asset('images/'.$image[0])}}" style="width: 70%; height: 60px; "></a>
										</div>
										<div class="col-md-5 text-left">
											<p></p>
											<p>{{__('client.size')}} : {{ $details['size'] }}</p>
											<p>{{__('client.color')}} : {{ $details['color'] }}</p>
										</div>
									</div> 
								</td>
								<td class="product-name">
									<a href="{{route('products.show',$details['slug'])}}">{{ $details['name'] }}</a>					
								</td>
								<td class="product-price col-md-1">
									<span class="amount">{{ number_format($details['price']) }}đ</span>					
								</td>
								<td class="product-quantity col-md-1">
									<div class="quantity"><input type="number" min="1" max="20" class=" form-control productquantity" name="quantity[]" value="{{$details['quantity']}}" id="product_quantity{{$details['id']}}"  style="width: 60px;" data-columns="{{$details['id']}}"></div>
								</td>
								<td class="product-subtotal col-md-1">
									<span class="amount">{{number_format($details['price'] * $details['quantity'])}}đ</span>					
								</td>
							</tr>
							@endforeach
							@else 
							<p>Cart is empty!</p>
							@endif
						</tbody>
					</table>
				</div>
				<form method="POST" action="{{ url('/checkout') }}" >
				@csrf
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 ">
						<div class="cart_totals">
							<h2>{{__('cart.carttotal')}}</h2>
							<div class="total_table">
								<table class="table-responsive">
									<tbody>
										<tr class="cart-subtotal">
											<th>{{__('cart.subtotal')}}</th>
											<td><span class="amount">{{number_format($total)}}đ</span></td>
										</tr>
										<tr class="shipping">
											<th>{{__('cart.Shipping')}}</th>
											<td>{{__('cart.ship')}}</td>
										</tr>
										<tr class="order-total">
											<th>{{__('cart.total')}}</th>
											<td><strong><span class="amount">{{number_format($total)}}đ</span></strong> </td>
										</tr>
									</tbody>
								</table>
								<div class="submit_crt">
									@if(session('cart'))	
									<input type="submit" class="proceed_chack" value="{{__('cart.ProceedtoCheckout')}}">
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">{{__('cart.Deleteproductformcart')}}</h4>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">{{__('cart.cancel')}}</button>
        <button type="button" class="btn btn-danger delete">{{__('cart.delete')}}</button>
      </div>
    </div>
  </div>
</div>
<!--page-checkout AREA END -->
@foreach($abouts as $key => $about)
<input type="hidden" value="{{$about->title}}" id="titlevalue">
<input type="hidden" value="{{$about->name}}" id="namevalue">
<input type="hidden" value="{{$about->address}}" id="addressvalue">
<input type="hidden" value="{{$about->email}}" id="emailvalue">
<input type="hidden" value="{{$about->phone}}" id="phonevalue">
<input type="hidden" value="{{asset('images/'.$about->logo)}}" id="logovalue">
@endforeach
<script src="{{asset('client/js/setabout.js')}}"></script>
<script type="text/javascript">
	$(".productquantity").change(function(){
		var id = this.dataset.columns;
		var quantity = parseInt($(this).val());
		$.ajax({
			url: '{{ url('update-cart') }}',
			method: "patch",
			data: {_token: '{{ csrf_token() }}', id: id, quantity: quantity},
			success: function (response) {
				window.location.reload();
			}
		});
	}); 
	$(".remove-from-cart").click(function (e) {
		e.preventDefault();
		var id = $(this).val();
		$(".delete").click(function(){
			$.ajax({
				url: '{{ url('remove-from-cart') }}',
				method: "DELETE",
				data: {_token: '{{ csrf_token() }}', id: id},
				success: function (response) {
					window.location.reload();
				}
			});
		});
	});
</script>
@endsection
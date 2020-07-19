@extends('user.layout.main')
@section('title',$product->name)
@section('content')
<style>
	input#quantity{
		float: left;
		margin-top: 1px;
		padding: 7px 0px;
		border: 1px solid #e6e6e6;
		margin-left: 2px;
		margin-right: 2px;
	}
</style> 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">Home</a> <span>/</span> <a href="{{url('products')}}">Products</a> <span>/</span>{{$product->name}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
@if(session('success'))
<div class="alert alert-success text-center notification" >
	{{ session('success') }}
</div>
@endif
<!--PRODUCT CATEGORY START -->
<div class="blog_right_sidebar_area product_category product_left ">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 ">
				<!--product category left sidebar -->
				<div class="product_left_left_sidebar">
					<div class="right_sidebar_menu">
						<div class="right_menu_title">
							<h2 class="widgettitle"> <i class="fa fa-bars"></i> <span>CATEGORIES</span>  </h2>
						</div>
						<div class="r_menu" style="overflow-x: auto; height: 450px;">
							<ul>
								@foreach($categories as $key => $category)
								<li><a href="{{route('products.index')}}?category={{$category->name}}">{{ $category->name }}</a></li>
								@endforeach
							</ul>
						</div>
					</div>
					<div class="info_widget">
						<div class="section_title">
							<h2 class="" style="float: left;">Top Rated Products</h2>
						</div>
						<div style="clear: both;"></div>
						@foreach($list_product_votes as $key => $list_product_vote)
						@if($key < 4) 
						<div class="top_single_prodct">
							<a href="{{route('products.show',$list_product_vote[0]['slug'])}}" title="{{$list_product_vote[0]['name']}}"><img src="{{asset('images/'.$list_product_vote[0]['image'])}}" alt="" style="width: 30%;" /></a>
							<div class="">
								<p class="name"><a href="{{route('products.show',$list_product_vote[0]['slug'])}}" title="{{$list_product_vote[0]['name']}}">{{ str_limit($list_product_vote[0]['name'],24) }}</a></p>
								<div class="star-rating fullstr  ">
									@for($i = 0; $i < 5; $i++)
									@if($i < $list_product_vote_id[$list_product_vote[0]['id']])
									<i class="fa fa-star" style="color: #ffcc00;"></i>
									@else
									<i class="far fa-star" style="color: #ffcc00;"></i>
									@endif
									@endfor
								</div>
								<span class="price"><span class="amount">{{$list_product_vote[0]['price']}}đ</span></span>
							</div>
						</div>
						@endif
						@endforeach 
					</div>		
					<div class="info_widget">
						<div class="small_slider">
							<!-- single_slide -->
							<div class="single_slide">
								<img src="{{asset('client/img/slider/8.jpg')}}" alt="" />
								<div class="s_slider_text">
									<h2>MEET <br />THE <br />MARKET</h2>
								</div>
							</div> 
							<!-- single_slide -->
							<div class="single_slide">
								<img src="{{asset('client/img/slider/7.jpg')}}" alt="" />
								<div class="s_slider_text another">
									<h2>AWESOME <br />BANNER</h2>
								</div>
							</div> 
						</div>
					</div> 
				</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9 ">
				<div class="row">
					<div class="col-lg-7 col-md-7 col-sm-7 ">
						<div class="product_gallery">
							<ul id="gallery_imgs">
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('images/'.$product->image)}}"><img src="{{asset('images/'.$product->image)}}" alt="" style="height: 450px;" /></a></li>
								@foreach($images as $key=>$value)
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('images/'.$value->name)}}"><img src="{{asset('images/'.$value->name)}}" alt="" style="height: 450px;" /></a></li>
								@endforeach 
								<!-- <li><a class="fancybox" data-fancybox-group="group" href="{{asset('client/img/product-gallery/full2.jpg')}}"><img src="{{asset('client/img/product-gallery/full2.jpg')}}" alt=""/></a></li>
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('client/img/product-gallery/full3.jpg')}}"><img src="{{asset('client/img/product-gallery/full3.jpg')}}" alt="" /></a></li>
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('client/img/product-gallery/full2.jpg')}}"><img src="{{asset('client/img/product-gallery/full2.jpg')}}" alt="" /></a></li>
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('client/img/product-gallery/full3.jpg')}}"><img src="{{asset('client/img/product-gallery/full3.jpg')}}" alt=""/></a></li>
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('client/img/product-gallery/full2.jpg')}}"><img src="{{asset('client/img/product-gallery/full2.jpg')}}" alt=""/></a></li>
								<li><a class="fancybox" data-fancybox-group="group" href="{{asset('client/img/product-gallery/full3.jpg')}}"><img src="{{asset('client/img/product-gallery/full3.jpg')}}" alt=""/></a></li> -->
							</ul>
							<div class="bxpage_slider" id="bx-pager">
								<a data-slide-index="0"  href=""><img class="select" src="{{asset('images/'.$product->image)}}" style="height: 100px;" /></a>
								@foreach($images as $key=>$value)
								<?php ++$key ?>
								<a data-slide-index="{{$key}}"  href=""><img class="select" src="{{asset('images/'.$value->name)}}" style="height: 100px;" /></a>
								@endforeach 
								<!-- <a data-slide-index="0" href=""><img class="select" src="{{asset('client/img/product-gallery/thumb/thumb2.jpg')}} " alt="thumb2.jpg"/></a>
								<a data-slide-index="1" href=""><img src="{{asset('client/img/product-gallery/thumb/thumb3.jpg')}}" alt="thumb3.jpg" /></a>
								<a data-slide-index="2" href=""><img src="{{asset('client/img/product-gallery/thumb/thumb2.jpg')}}" alt="thumb4.jpg" /></a>
								<a data-slide-index="3" href=""><img src="{{asset('client/img/product-gallery/thumb/thumb3.jpg')}}" alt="thumb5.jpg" /></a>
								<a data-slide-index="4" href=""><img src="{{asset('client/img/product-gallery/thumb/thumb2.jpg')}}" alt="thumb6.jpg" /></a>
								<a data-slide-index="5" href=""><img src="{{asset('client/img/product-gallery/thumb/thumb3.jpg')}}" alt="thumb7.jpg" /></a> -->
							</div>
						</div>
					</div>	
					<div class="col-lg-5 col-md-5 col-sm-5 ">
						<div class="product_info col-md-12">
							<div class="col-md-12">
								<p class="name" style="color: black; font-size: 30px;line-height: 30px;">{{$product->name}}</p>
								<input type="hidden" value="{{ $product->id }}" id="productid">
								<div class="star-rating  ">
									<?php $star = 0; ?>
									@foreach($comments as $key => $comment)
									<?php $star += $comment->star; ?>
									@endforeach
									<?php
									if (count($comments)) {
										$star = round($star/count($comments));
									}else{
										$star = 5;
									} 
									?>
									@for ($i = 0; $i < 5; $i++)
									@if($i < $star)
									<i class="fa fa-star" style="color: #ffcc00;"></i>
									@else
									<i class="far fa-star" style="color: #ffcc00;"></i>
									@endif
									@endfor
								</div>
								<span class="price"><span class="amount">{{$product->price}}đ</span></span>
								<br><br>
							</div>
							<div class="sort_section">
								<form action="{{ url('add-to-cart/'.$product->id) }}" onsubmit="return checkform();">
									<!-- size -->
									<ul class="sort-bar">
										<li class="sort-bar-text">Size: </li>
										<li></li>
										<li  class="customform" >
											<?php
											if (isset($sizes)) {
												$list = array();
												foreach ($sizes as $key => $size) {
													$list[] = $size->size;
												}
												$list = array_unique($list);
											}
											?>
											<div class="select-wrapper">
												<select name="size" class="orderby" id="size">
													<option value="" selected="selected">
													Select size!</option>
													@foreach($list as $key => $size)
													<option value="{{$size}}">{{$size}}</option>
													@endforeach
												</select>
											</div>
										</li>
									</ul>
									<!-- color -->
									<ul class="sort-bar">
										<li class="sort-bar-text">Color: </li>
										<li></li>
										<li  class="customform" >
											<div class="select-wrapper">
												<select name="color" class="orderby" id="color">
													<option value="">Selcet color!</option>
												</select>
											</div>
										</li>
									</ul> 
									<!-- quantity -->
									<ul class="sort-bar">
										<li class="sort-bar-text">Quantity: </li>
										<li></li>
										<li class="customform" >
											<button type="button" class="btn" onclick="document.getElementById('quantity').stepDown();" style="float: left;">-</button>
											<input type="number" name="quantity" min="1" max="100" value="1" class="text-center"  id="quantity">
											<button type="button" class="btn" onclick="document.getElementById('quantity').stepUp();">+</button>
											<span style="margin-left: 10px;">  Products available: <span id="quantityava" class="text-danger">{{ $quantity }}</span></span>
											<input type="hidden" id="quantitystore" value="{{ $quantity }}">
										</li>
									</ul>
									<p class="checkerr text-danger"></p>
									<button type="submit" class="btn btn-success"><i class="fas fa-cart-plus" style="font-size: 20px;"></i> <b>ADD TO CART</b></button>
								</form>	
							</div>
							<div class="product_meta">
								<span class="sku_wrapper">Brand: {{$product->brand->name}}</span>
								<span class="posted_in">Category: <a rel="tag" href="{{route('products.index')}}?category={{$product->category->name}}">{{$product->category->name}}</a></span>
							</div>
						</div>
					</div>
					<!--PRODUCT TAB COLLECTION AREA   START -->
					<div class="tab_collection_area product_tab ">
						<div id="tab-container" class='tab-container'>
							<ul class='etabs '>
								<li class='tab'><a href="#description">Description</a></li>
								<li class='tab'><a href="#reviews">Comments ({{count($comments)}})</a></li> 
							</ul>
							<div class='panel-container'>
								<!-- first_collection -->
								<div id="description">	
									<p>Tail sed sausage magna quis commodo swine. Aliquip strip steak esse ex in ham hock fugiat in. Labore velit pork belly eiusmod ut shank doner capicola consectetur landjaeger fugiat excepteur short loin. Pork belly laboris mollit in leberkas qui. Pariatur swine aliqua pork chop venison veniam. Venison sed cow short loin bresaola shoulder cupidatat capicola drumstick dolore magna shankle.</p>
								</div>
								<!-- second_collection -->
								<div id="reviews" style="background: #f5f5f5;"> 
									<hr style="margin: 0;">
									@foreach($comments as $key => $comment)
									<div class="bg-light" style="margin-bottom: 15px; background: white;border-radius: 4px;">
										<div class="row no-gutters" style="margin: 10px 0px;"> 
											<div class="col-xs-12 col-md-12">
												<div class="card-body"> 
													<h4 style="margin: 5px 0;">{{$comment->user->first_name.' '.$comment->user->last_name}}</h4>
													@for ($i = 0; $i < 5; $i++)
													@if($i < $comment->star)
													<i class="fa fa-star" style="color: #ffcc00;"></i>
													@else
													<i class="far fa-star" style="color: #ffcc00;"></i>
													@endif
													@endfor 
													<p style="margin: 5px 0px 0px 0px;">{{$comment->content}}</p> 
													<p class="card-text "><small class="text-muted">{{$comment->created_at}}</small></p>
												</div>
											</div>  
										</div>
									</div>
									@endforeach 
									<hr style="margin: 0;">
								</div> 
							</div>
						</div>
					</div>
					<!--PRODUCT TAB COLLECTION AREA  END -->
				</div>	
				<!-- RELATED  PRODUCS  -->
				<div class="featured_producs related_product ">
					<div class="section_title">
						<h2>Related Products</h2>
					</div>
					<div class = 'slider8'> 
						@foreach($productbycategories as $key => $productbycategory)
						<!-- product Item -->
						<div class=" single_item"> 
							<div class = 'item' >
								<a href="{{route('products.show',$productbycategory->slug)}}">
									<div class="product_img">
										<img src="{{asset('images/'.$productbycategory->image)}}" alt="" style="height: 200px;" />
									</div>
									<div class="addtocart_area">
										<a href="{{route('products.show',$productbycategory->slug)}}">
											<div class="cart-icons">
												<strong><span class="fa fa-shopping-cart"></span></strong>
												<span class="cart-icon-handle"></span>
												<span class="add-to-cart-text">ADD TO CART</span>
											</div>
										</a>
									</div>
								</a>
							</div>
							<!-- product info -->
							<div class="info ">
								<p class="name" style="height: 40px;"><a href="{{route('products.show',$productbycategory->slug)}}" title="{{$productbycategory->name}}">{{str_limit($productbycategory->name, 34)}}</a></p> 
								@if($productbycategory->promotion)
								<del><span class="amount nrb">{{ $productbycategory->price }}đ</span></del>
								<span class="price"><span class="amount">{{ $productbycategory->price - intval(($productbycategory->price * $productbycategory->promotion)/100) }}đ</span></span>
								@else
								<span class="price"><span class="amount">{{ $productbycategory->price }}đ</span></span>
								@endif 
							</div>
							@if($productbycategory->promotion)
							<div class="inner">
								<div class="inner-text">Sale!</div>
							</div>
							@endif 
						</div>
						@endforeach
					</div>
				</div>
				<!-- Related Products PRODUCS END  -->
			</div>	
		</div>	
	</div>	
</div>	
<!--PRODUCT CATEGORY END -->
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
	$(".bx-wrapper").hide();
	function checkform() {
		var size = $('#size').val();
		var color = $('#color').val();
		var result = true;
		var quantitystore = $('#quantitystore').val();
		var quantity = $('#quantity').val(); 
		if (!size || !color) {
			$('.checkerr').html('Please select Size and Color!');
			result = false;
		}else{ 
			if (parseInt(quantity) > parseInt(quantitystore)) { 
				result = false;
				$('.checkerr').html('Quantity must be less than '+quantitystore+'!');
			}
		}
		return result;
	}
	$('select#size').change(function(){
		var size = $(this).val();
		var product_id = $('#productid').val();
		if (size) {
			$.ajax({
				type: 'get',
				url: '{{ URL::to('get_color_in_productdetail') }}',
				data: {
					product_id: product_id,
					size: size
				},
				success:function(data){
					$option = '<option value="">Selcet color!</option>';
					for (var i = 0; i < data.length; i++) {
						$option += '<option value="'+data[i]+'">'+data[i]+'</option>';
					}
					$('#color').html($option);
				}
			});
			getquantity(product_id,size,'');
		}else{
			$('#color').html('<option value="">Selcet color!</option>');
			$('#quantityava').html({{$quantity}});
			$('#quantitystore').val({{$quantity}});
		}
	});
	$('select#color').change(function(){
		var color = $(this).val();
		var product_id = $('#productid').val();
		var size = $('#size').val();
		getquantity(product_id,size,color);
	});
	function getquantity(product_id,size,color) {
		$.ajax({
			type: 'get',
			url: '{{ URL::to('get_quantity_in_productdetail') }}',
			data: {
				product_id: product_id,
				size: size,
				color: color
			},
			success:function(data){
				$('#quantityava').html(data);
				$('#quantitystore').val(data);
			}
		});
	}
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
<!-- RIGHT SIDEBAR MENU AREA END -->
@endsection
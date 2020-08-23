@extends('user.layout.main')
@section('title',__('client.Product'))
@section('content') 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span>{{__('client.Product')}}</h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!--BREADCRUMB AREA END -->
<!-- banner slider start -->
<div class="add-slider-area banner-slider-area">
	<div class="slider-container">
		<!-- Slider Image -->
		<div class="mainSlider nivoSlider slider-image"> 
			<img src="{{asset('images/background.jpg')}}" alt="main slider" title="#htmlcaption1" />
		</div>
		<!-- Slider Caption 1 -->
		<div id="htmlcaption1" class="nivo-html-caption slider-caption-1">
			<div class="slider-progress"></div>
			<div class="slide1-text text-2">
				<div class="middle-text">
					<div class="cap-dec wow bounceInDown" data-wow-duration="0.9s" data-wow-delay="0s">
						<h1 style="color: white;">New Fashions</h1>
					</div>
					<div class="cap-title wow bounceInRight" data-wow-duration="1.2s" data-wow-delay="0.2s">
						<h2 style="color: white;">All Shoes </h2>
					</div> 
				</div>
			</div>
		</div> 
	</div>
</div>
<!-- banner slider end -->
@if(session('success'))
<div class="alert alert-success text-center" >
	{{ session('success') }}
</div>
@endif
<!--PRODUCT CATEGORY START -->
<div class="blog_right_sidebar_area product_category">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 ">
				<!--product category left sidebar -->
				<div class="blog_right_sidebar_right_area">
					<!-- single widget -->
					<form action="" method="GET" id="formsort">
						<div class="info_widget">
							<div class="section_title">
								<h2>{{__('client.Filterbycategory')}}</h2>
							</div>
							<ul class="product-categories">
								@foreach($categories as $key => $category)
								<li class="col-md-12">
									<input type="checkbox" name="category[]" id="{{$category->slug}}" value="{{$category->slug}}" class="col-md-1 cate" style="margin-top: 7px;">
									<label for="{{$category->slug}}" class="col-md-9">{{ $category->slug }}</label>
									<span class="count col-md-2">({{ $listquantity[$key] }})</span>
								</li>
								@endforeach
							</ul>
						</div>
						<!-- single widget -->
						<div class="info_widget">
							<div class="section_title">
								<h2>{{__('client.FilterbyPrice')}}</h2>
							</div>
							<ul class="product-categories">
								<li class="col-md-12">
									<input type="checkbox" name="price[]" id="pmax1000000" value="max1000000" style="margin-top: 7px;">
									<label for="pmax1000000"><1,000,000</label>
								</li>
								<li class="col-md-12">
									<input type="checkbox" name="price[]" id="p1000000-2000000" value="1000000-2000000" style="margin-top: 7px;">
									<label for="p1000000-2000000">1,000,000-2,000,000</label>
								</li>
								<li class="col-md-12">
									<input type="checkbox" name="price[]" id="p2000000-5000000" value="2000000-5000000" style="margin-top: 7px;">
									<label for="p2000000-5000000">2,000,000-5,000,000</label>
								</li>
								<li class="col-md-12">
									<input type="checkbox" name="price[]" id="pmin5000000" value="min5000000" style="margin-top: 7px;">
									<label for="pmin5000000">>5,000,000</label>
								</li>
							</ul> 
						</div>
						<!-- single widget -->
						<div class="info_widget">
							<div class="section_title">
								<h2>{{__('client.Filterbycolor')}}</h2>
							</div>
							<ul class="product-categories">
								@foreach($listcolorquantity as $key => $value)
								<li class="col-md-12">
									<input type="checkbox" name="color[]" id="{{$key}}" class="cate col-md-1" value="{{$key}}" style="margin-top: 7px;">
									<label for="{{$key}}" class="col-md-9"><?php echo ucwords($key); ?></label>
									<span class="count col-md-1">({{$value}})</span>
								</li>
								@endforeach 
							</ul>
						</div>
						<input type="hidden" value="{{ isset($_GET['productname']) ? $_GET['productname']: ''}}" name="productname" id="productname">
						<input type="hidden" value="{{ isset($_GET['orderby']) ? $_GET['orderby']: ''}}"   id="getsort">
						<!-- single widget -->
						<div class="info_widget">
							<div class="small_slider">
								<!-- single_slide -->
								@foreach($banners as $key => $banner)
								<div class="single_slide">
									<img src="{{asset('images/'.$banner->url_img)}}" alt="" />
									<div class="s_slider_text">
										<h2>MEET <br />THE <br />MARKET</h2>
									</div>
								</div> 
								@endforeach 
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 ">
					<div class="row">
						<!--product category right sidebar -->
						<div class="category_right_area">
							<div class="view_sort_area">
								<div class="col-lg-4 col-md-4 col-sm-6 ">
									<div class="sort_section">
										<ul class="sort-bar">
											<li class="sort-bar-text">{{__('client.Sortby')}}</li>
											<li> 
												<div class="select-wrapper">
													<select class="orderby form-control" name="orderby" id="orderbyprice"> 
														<option value="">{{__('client.Default')}}</option>
														<option value="asc">{{__('client.Pricelowtohigh')}}</option>
														<option value="desc">{{__('client.Pricehighttolow')}}</option>	
													</select>
												</div>
											</li>
										</ul>
									</form>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 ">
							</div>
						</div>
						<!-- PRODUCTS -->
						<div class="cat_all_aitem">
							<div class = 'short-width-slider'>
								<div class = 'cat_slider'>
									@if(count($products) == 0)
									<p>No products!</p>
									@endif
									@foreach($products as $key => $product)
									<div class="col-md-4 col-xs-6 single_item" style="padding-right: 0">
										<!-- product Item -->
										<a href="{{route('products.show',$product->slug)}}">
											<div class = 'item' style="position: relative;">
												<div class="product_img"> 
													<img src="{{asset('images/'.$product->image)}}" alt="" style="height: 200px;" />
												</div>
												<div class="addtocart_area">
													<a href="{{route('products.show',$product->slug)}}">
														<div class="cart-icons">
															<strong><span class="fa fa-shopping-cart"></span></strong>
															<span class="cart-icon-handle"></span>
															<span class="add-to-cart-text">{{__('client.addtocart')}}</span>
														</div>
													</a>
												</div>
											</div>
										</a>
										<!-- product info -->
										<div class="info ">
											<p class="name" ><a href="{{route('products.show',$product->slug)}}" title="{{$product->name}}">{{ str_limit($product->name,60) }}</a></p> 
											@if ($product->promotion)
											<del><span class="amount nrb">{{ number_format($product->price) }}đ</span></del>
											<span class="price"><span class="amount">{{ number_format($product->price - intval(($product->price * $product->promotion)/100)) }}đ</span></span>
											@else    
											<span class="price"><span class="amount">{{ number_format($product->price) }}đ</span></span>
											@endif
										</div>
										@if ($product->promotion)
										<div class="inner">
											<div class="inner-text">Sale!</div>
										</div>
										@endif
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>	
				</div>
				<!-- paginate -->
				<div class="">
					{{$products->links()}}	
				</div>
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
<script type="text/javascript">
	var orderby = $("#getsort").val();
	var productname = $("#productname").val(); 
	$("input[name='category[]']").change(function(){ 
		if (!productname) {
			document.getElementById("productname").setAttribute("disabled", true);
		}
		if (!orderby) {
			document.getElementById("orderbyprice").setAttribute("disabled", true);
		}
		this.form.submit();
	}); 
	$("input[name='price[]']").change(function(){ 
		if (!productname) {
			document.getElementById("productname").setAttribute("disabled", true);
		}
		if (!orderby) {
			document.getElementById("orderbyprice").setAttribute("disabled", true);
		}
		this.form.submit();
	});
	$("input[name='color[]']").change(function(){ 
		if (!productname) {
			document.getElementById("productname").setAttribute("disabled", true);
		}
		if (!orderby) {
			document.getElementById("orderbyprice").setAttribute("disabled", true);
		}
		this.form.submit();
	});
	$("#orderbyprice").change(function(){
		if (!$(this).val()) {
			document.getElementById("orderbyprice").setAttribute("disabled", true);
		}
		if (!productname) {
			document.getElementById("productname").setAttribute("disabled", true);
		}
		this.form.submit();
	}); 
	@if(isset($_GET['category']))  
	<?php foreach ($_GET['category'] as $key => $value): ?> 
		rates = document.getElementsByName('category[]');
        rates.forEach((rate) => { 
        	if (`${rate.value}` == '{{$value}}') {
        		$("#"+'{{$value}}').prop("checked", true); 
        	}
                     
        }); 
	<?php endforeach ?>
	@endif
	@if(isset($_GET['price']))
		@foreach($_GET['price'] as $key => $value) 
		rates = document.getElementsByName('price[]');
        var	price = '{{$value}}';  
        rates.forEach((rate) => {  
        	if (`${rate.value}` == price) {
        		$("#p"+price).prop("checked", true); 

        	}       
        });  
		@endforeach  
	@endif
	@if(isset($_GET['color']))
		@foreach($_GET['color'] as $key => $value)
		rates = document.getElementsByName('color[]');
        rates.forEach((rate) => { 
        	if (`${rate.value}` == '{{$value}}') {
        		$("#"+'{{$value}}').prop("checked", true); 
        	}
                     
        }); 
		@endforeach
	@endif
	@if(isset($_GET['orderby']))
		$("#orderbyprice").val('{{$_GET['orderby']}}');
	@endif
</script> 
@endsection
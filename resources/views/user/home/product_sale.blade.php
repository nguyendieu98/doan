@extends('user.layout.main')
@section('title',__('client.Sale'))
@section('content') 
<!--BREADCRUMB AREA START -->
<div class="breadcrumb_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">	
				<div class="breadcrumb-row">
					<h3 class="breadcrumb"><a href="/" class="home">{{__('client.Home')}}</a><span>/</span>{{__('client.productsale')}}</h3>
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
								<h2>{{__('client.TopRatedProducts')}}</h2>
							</div>
						</div> 
						<!-- single widget -->
						<div class="info_widget"> 
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
										<span class="price"><span class="amount">{{number_format($list_product_vote[0]['price'])}}đ</span></span>
									</div>
							</div>
							@endif
							@endforeach 
						</div>
						<input type="hidden" value="{{ isset($_GET['productname']) ? $_GET['productname']: ''}}" name="productname" id="productname">
						<input type="hidden" value="{{ isset($_GET['orderby']) ? $_GET['orderby']: ''}}"   id="getsort">
						<!-- single widget -->
						<div class="info_widget">
							<div class="small_slider">
								<!-- single_slide -->
								<div class="single_slide">
									<img src="{{asset('images/baner1.jpg')}}" alt="" />
									<div class="s_slider_text">
										<h2>MEET <br />THE <br />MARKET</h2>
									</div>
								</div> 
								<!-- single_slide -->
								<div class="single_slide">
									<img src="{{asset('images/baner2.png')}}" alt="" />
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
						<!--product category right sidebar -->
						<div class="category_right_area">
							<div class="view_sort_area">
								<div class="col-lg-4 col-md-4 col-sm-6 ">
									<div class="sort_section">
										<!-- form -->
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
	@endsection
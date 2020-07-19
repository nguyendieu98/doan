@extends('user.layout.main')
@section('title','Home')
@section('content')
<!-- RIGHT SIDEBAR MENU AREA START -->
<div class="right_sidebar_menu_area">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
				<div class="right_sidebar_menu">
					<div class="right_menu_title">
						<h1 class="widgettitle"> <i class="fa fa-bars"></i> <span>CATEGORIES</span>  </h1>
					</div>
					<div class="r_menu" style="overflow-x: auto; height: 450px;">
						<ul>
							@foreach($categories as $key => $category)
							<li><a href="{{route('products.index')}}?category[]={{$category->name}}">{{ $category->name }}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 middle-slider index3_sliderrow ">
				<!-- home slider start -->
				<div class="">
					<!-- Slider Image -->
					<div class="mainSlider classslide" style="max-height: 500px;">
						@foreach($slides as $key => $slide)
						<img src="{{asset('images/'.$slide->url_img)}}" alt="main slider" title="#htmlcaption111"  style="height: 100%;" />
						@endforeach
					</div>
					<!-- Slider Caption 1 -->
					<div id="htmlcaption111" class="nivo-html-caption slider-caption-1">
						<div class="slider-progress"></div>
						<div class="slide1-text">
							<div class="middle-text mdd-slide">
								<div class="cap-dec wow bounceInDown" data-wow-duration="0.9s" data-wow-delay="0s">
									<h2 class="cap-3-h">Latest collection 2020</h2>
								</div>
								<div class="cap-title wow bounceInRight" data-wow-duration="1.2s" data-wow-delay="0.2s">
									<h3 class="cap-3-h-2">Best Shoes</h3>
								</div>
								<div class="cap-readmore wow bounceInUp" data-wow-duration="1.3s" data-wow-delay=".5s">
									<a href="/products">shop now</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- home slider end -->
			</div>
		</div>
	</div>
</div>
<!-- RIGHT SIDEBAR MENU AREA END -->
<!--TAB COLLECTION AREA  START -->
<div class="row col-md-12">
	<div class="col-md-3">
		<br>
		<div class="info_widget col-xs-6 col-md-12">
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
					@if ($list_product_vote[0]['promotion'])
						<del><span class="amount nrb">{{ $list_product_vote[0]['price'] }}đ</span></del>
						<span class="price"><span class="amount">{{ $list_product_vote[0]['price'] - intval(($list_product_vote[0]['price'] * $list_product_vote[0]['promotion'])/100) }}đ</span></span>
					@else    
						<span class="price"><span class="amount">{{$list_product_vote[0]['price']}}đ</span></span>
					@endif  
				</div>
			</div>
			@endif
			@endforeach 
		</div>
		<div class="info_widget col-xs-6 col-md-12">
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
	<div class="col-md-9">
		<div class="tab_collection_area" style="clear: both;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 ">
						<div class="section_title row"> 
							<hr class="col-md-4" style="margin-left: 1.1%;">
							<h2 class="text-center col-md-3"><a href="{{route('products.index')}}?sale=sale" style="text-decoration: none; color: black;">Sale</a></h2>
							<hr class="col-md-4">
						</div>	
						<div class='panel-container row'>
							<!-- first_collection -->
							<div id="women">	
								<div class = 'short-width-slider'>
									<div class = 'slider1'>
										@foreach($product_promotions as $key => $product)
										<div class="col-xs-12">
											<div class="single_item">
												<!-- product Item -->
												<a href="{{route('products.show',$product->slug)}}">
													<div class = 'item'>
														<div class="product_img">
															<img src="{{asset('images/'.$product->image)}}" alt="" style="height: 200px;" /> 
														</div>
														<div class="addtocart_area"> 
															<div class="cart-icons">
																<strong><span class="fa fa-shopping-cart"></span></strong>
																<span class="cart-icon-handle"></span>
																<span class="add-to-cart-text">ADD TO CART</span>
															</div> 
														</div>
													</div>
												</a>
												<!-- product info -->
												<div class="info ">
													<p class="name" style="height: 40px; line-height: 20px;" title="{{$product->name}}"><a href="{{route('products.show',$product->slug)}}">{{ str_limit($product->name,50) }}</a></p> 
													<del><span class="amount nrb">{{ $product->price }}đ</span></del>
													<span class="price"><span class="amount">{{ $product->price - intval(($product->price * $product->promotion)/100) }}đ</span></span>
												</div>
												<div class="inner">
													<div class="inner-text">Sale!</div>
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div> 
						</div> 
					</div>
				</div>
			</div>
		</div> 
		<div class="tab_collection_area">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 ">
						<div class="section_title row">
							<hr class="col-md-4" style="margin-left: 1.1%;">
							<h2 class="text-center col-md-3"><a href="/products" style="text-decoration: none; color: black;">New products</a></h2>
							<hr class="col-md-4">
						</div>	
						<div class='panel-container row'>
							<!-- first_collection -->
							<div id="women">	
								<div class = 'short-width-slider'>
									<div class = 'slider1'>
										@foreach($newproducts as $key => $newproduct)
										<div class="col-xs-12">
											<div class="single_item">
												<!-- product Item -->
												<a href="{{route('products.show',$newproduct->slug)}}">
													<div class = 'item'>
														<div class="product_img">
															<img src="{{asset('images/'.$newproduct->image)}}" alt="" style="height: 200px;" />
														</div>
														<div class="addtocart_area"> 
															<div class="cart-icons">
																<strong><span class="fa fa-shopping-cart"></span></strong>
																<span class="cart-icon-handle"></span>
																<span class="add-to-cart-text">ADD TO CART</span>
															</div> 
														</div>
													</div>
												</a>
												<!-- product info -->
												<div class="info ">
													<p class="name" style="line-height: 20px; height: 40px;"><a href="{{route('products.show',$newproduct->slug)}}" title="{{$newproduct->slug}}">{{ str_limit($newproduct->name,50) }}</a></p> 
													@if($newproduct->promotion)
													<del><span class="amount nrb">{{ $newproduct->price }}đ</span></del>
													<span class="price"><span class="amount">{{ $newproduct->price - intval(($newproduct->price * $newproduct->promotion)/100) }}đ</span></span>
													@else
													<span class="price"><span class="amount">{{ $newproduct->price }}đ</span></span>
													@endif 
												</div>
												@if($newproduct->promotion)
												<div class="inner">
													<div class="inner-text">Sale!</div>
												</div>
												@endif 
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div> 
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="our_brand_area">
	<div class="container-fluid">
		<div class="section_title row">
			<hr class="col-md-5" style="margin-left: 1.1%;">
			<h2 class="col-md-2">OUR BRANDS</h2>
			<hr class="col-md-4">
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 ">
				<div class="brand">
					<!-- SINGLE BRAND -->
					<div class="brand_item">
						<div class="band_single">
							<a href="#">
								<img src="{{asset('images/nikelogo.jpg')}}" alt="" />
							</a>
						</div>
						<div class="band_single">
							<a href="#">
								<img src="{{asset('images/vanslogo.png')}}" alt="" />
							</a>
						</div>
						<div class="band_single">
							<a href="#">
								<img src="{{asset('images/converselogo.png')}}" alt="" />
							</a>
						</div>
						<div class="band_single">
							<a href="#">
								<img src="{{asset('images/balenlogo.png')}}" alt="" />
							</a>
						</div>
						<div class="band_single">
							<a href="#">
								<img src="{{asset('images/yeezylogo.png')}}" alt="" />
							</a>
						</div>
						<div class="band_single">
							<a href="#">
								<img src="{{asset('images/adidaslogo.png')}}" alt="" />
							</a>
						</div> 
					</div>
				</div>
			</div>
		</div>	
	</div>		
</div>
<!--OUR BRANDS AREA AREA END -->
@foreach($abouts as $key => $about)
<input type="hidden" value="{{$about->title}}" id="titlevalue">
<input type="hidden" value="{{$about->name}}" id="namevalue">
<input type="hidden" value="{{$about->address}}" id="addressvalue">
<input type="hidden" value="{{$about->email}}" id="emailvalue">
<input type="hidden" value="{{$about->phone}}" id="phonevalue">
<input type="hidden" value="{{asset('images/'.$about->logo)}}" id="logovalue">
@endforeach
@endsection
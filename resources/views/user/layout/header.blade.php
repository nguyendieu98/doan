<div id="preloader">
</div>	
<!--START HEADER TOP AREA  -->
<div class="header_top_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
				<div class="header_top">
					<div class="header_top_left pull-left ">
						<p id="title">Default welcome msg!</p>
					</div>
					<div class="header_top_right_menu pull-right ">
						<ul>
							<li><a href="/">Shop</a></li>
							<li><a href="{{url('contact')}}">Contact Us</a></li> 
							@auth('client')
							<li><a href="{{ url('/profile') }}" style="color: white;">{{ Auth::guard('client')->user()->username}}</a></li>
							<li>
								<a class="dropdown-item" href="{{ url('/') }}"
								onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>
							<form id="logout-form" action="{{ url('/logout') }}" method="GET" style="display: none;">
								@csrf
							</form>
						</li>
						@else
						<li><a href="{{ url('/login') }}">Login</a></li>
						<li><a href="{{ url('/register') }}">Register</a></li>
						@endauth
					</ul>
				</div>
			</div>
		</div>				
	</div>
</div>
</div>
</div>
<!--END HEADER TOP AREA  -->

<!--START HEADER TOP AREA  -->
<div class="header_area">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-3 col-md-3 col-sm-3">
				<div class="phone_area">
					<p><i class="fa fa-phone"></i> 
						<b>Call Us </b><span id="phone">(+80) 123 456 789 </span>
					</p>
				</div>		
			</div>
			<div class="col-xs-12 col-lg-3 col-md-3 col-sm-2">
				<div class="logo">
					<!--MOBILE MENU TRIGER-->
					<div class="mobilemenu_icone">
						<a id="mobile-menu" href="#sidr"><i class="fa fa-bars"></i></a>
					</div>
					<!--MOBILE MENU TRIGER-->
					<a href="/"><img src="{{asset('client/img/logo.png')}}" alt="" id="logo" style="width: 70%; height: 40px; margin-bottom: 5px;" /></a>
				</div>			
			</div>
			<div class="col-xs-12 col-lg-3 col-md-3 col-sm-3">	
				<form action="/products" method="GET">	 
					<div class="search">
						<input type="text" placeholder="Search…" name="productname" style="border: 1px solid #ddd; width: 100%; height: 38px; padding-left: 10px;"/>
						<button type="submit" style="height: 34px; margin-right: 1px;">
							<i class="fa fa-search"></i>
						</button>
					</div> 
				</form>			
			</div>
			<div class="col-xs-12 col-lg-3 col-md-3 col-sm-4">
				<div class="cart-wishlist">
					<ul>
						<li>
							<a href="{{url('/cart')}}">
								<div class="wishlist cart-inner">
									<div class="cart-icon">
										<i class="fa fa-shopping-cart"> </i>
										@if(session('cart'))
										<div class="cart-count text-center">
											<strong>
												{{count(session('cart'))}}
											</strong>
										</div>
										@endif
									</div>
								</div>	
							</a>	
						</li>
						<li>
							@auth('client')
							<a href="{{ url('/profile') }}">
								<div class="wishlist cart-inner">
									<div class="cart-icon">
										<i class="fas fa-user"></i>
									</div>
								</div>	
							</a>
							@endauth	
						</li>
					</ul>
				</div>		
			</div>
		</div>
	</div>
</div>
<!--END HEADER TOP AREA -->
<!--MOBILE MENU START -->
<div id="sidr">
	<nav>
		<ul>
			<li>
				<a href="{{url('/')}}">HOME</a>
			</li>
			<li>
				<a href="{{url('products')}}">Products</i></a>
			</li>
			<li>
				<a href="{{url('about')}}">About</a>
			</li>
			<li>
				<a href="{{url('contact')}}">Contact</a>
			</li>
			<li>
				<a href="{{route('products.index')}}?sale=sale">Sale</a>
			</li>
		</ul>						
	</nav>
</div>
<!--MOBILE MENU END -->
<!--MAIN MENU AREA  START-->
<div class="main_menu_area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 ">
				<!--DESKTOP MENU START -->
				<div class="mainmenu">
					<nav>
						<ul id="nav">
							<li>
								<a href="{{url('/')}}">HOME </a>
							</li>
							<li>
								<a href="{{url('products')}}">Products</a>
							</li>
							<li>
								<a href="{{url('about')}}">About</a>
							</li>
							<li>
								<a href="{{url('contact')}}">Contact</a>
							</li>
							<li >
								<a href="{{route('products.index')}}?sale=sale">Sale</a>
							</li>
						</ul>						
					</nav>
				</div>
				<!--DESKTOP MENU END -->
			</div>
		</div>
	</div>
</div>
<!--MAIN MENU AREA  END-->
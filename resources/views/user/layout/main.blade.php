<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Google font CSS=========================================== -->
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
	<!-- Favicon============================================ -->
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('client/img/favicon.png')}}">
	<!-- Bootstrap CSS============================================ -->
	<link rel="stylesheet" href="{{asset('client/css/bootstrap.min.css')}}">
	<!-- sidr mobile menu CSS============================================ -->
	<link rel="stylesheet" href="{{asset('client/css/jquery.sidr.light.css')}}">
	<!-- animate css -->
	<link rel="stylesheet" href="{{asset('client/css/animate.css')}}">
	<!-- jquery-ui CSS============================================ -->
	<link rel="stylesheet" href="{{asset('client/css/jquery-ui.css')}}">
	<!-- fancybox CSS============================================ -->
	<link rel="stylesheet" href="{{asset('client/css/fancybox/jquery.fancybox.css')}}">	
	<!--bxslider CSS============================================ -->
	<link rel="stylesheet" href="{{asset('client/css/jquery.bxslider.min.css')}}">	
	<!-- font-awesome CSS=========================================== -->
	<link rel="stylesheet" href="{{asset('client/css/font-awesome.min.css')}}">	
	<!-- nivo-slider css============================================ -->
	<link rel="stylesheet" href="{{asset('client/lib/css/nivo-slider.css')}}">	
	<!-- owl.carousel CSS============================================ -->
	<link rel="stylesheet" href="{{asset('client/css/owl.carousel.css')}}">
	<!-- normalize CSS============================================ -->		
	<link rel="stylesheet" href="{{asset('client/css/normalize.css')}}">
	<!-- main CSS============================================ -->		
	<link rel="stylesheet" href="{{asset('client/css/main.css')}}">
	<!-- style CSS============================================ -->			
	<link rel="stylesheet" href="{{asset('client/style.css')}}">
	<!-- responsive CSS	============================================ -->			
	<link rel="stylesheet" href="{{asset('client/css/responsive.css')}}">
	<!-- modernizr js============================================ -->		
	<script src="{{asset('client/js/vendor/modernizr-2.8.3.min.js')}}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">	
</head>
<body id="bodycontent">
	<div>
		@include('user.layout.header')
	</div>
	<div>
		@yield('content')
	</div>	
	<div>
		@include('user.layout.footer')
	</div>
</body> 
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
		FB.init({
			xfbml            : true,
			version          : 'v7.0'
		});
	};

	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution=setup_tool page_id="1387478951510015" theme_color="#13cf13"></div>
<!--Chatbot-Botman  -->
<script>
        // var botmanWidget = {
        //     aboutText: 'Shop',
        //     introMessage: "✋ Hi! Can i help you ?"
        // };
    </script> 
    <!-- <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script> -->
    <!--END Chatbot-Botman  -->

    <!-- ALL JS FILES -->
    <!-- jquery js -->
    <script src="{{asset('client/js/vendor/jquery-1.12.0.min.js')}}"></script>
    <!-- jquery easytabs js -->
    <script src="{{asset('client/js/jquery.easytabs.js')}}"></script>
    <!-- jquery scrollUp js -->
    <script src="{{asset('client/js/jquery.scrollUp.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('client/js/bootstrap.min.js')}}"></script>
    <!-- owl.carousel.min js -->
    <script src="{{asset('client/js/owl.carousel.min.js')}}"></script>
    <!-- FancyBox -->
    <script src="{{asset('client/js/jquery.fancybox.pack.js')}}"></script>
    <!-- jquery.easing js -->
    <script src="{{asset('client/js/jquery.easing.1.3.min.js')}}"></script>	
    <!-- bxslider js -->
    <script src="{{asset('client/js/jquery.bxslider.min.js')}}"></script>		
    <!-- nivo.slider js -->
    <script src="{{asset('client/lib/js/jquery.nivo.slider.pack.js')}}"></script>		
    <script src="{{asset('client/lib/js/nivo-active.js')}}"></script>
    <!-- wow js -->
    <script src="{{asset('client/js/wow.min.js')}}"></script>		
    <!-- plugins js -->
    <script src="{{asset('client/js/plugins.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('client/js/main.js')}}"></script>
    <script src="{{asset('client/js/setabout.js')}}"></script>
    <script>
    	setTimeout(function(){$(".notification").hide();},2500);
    </script>
    </html>
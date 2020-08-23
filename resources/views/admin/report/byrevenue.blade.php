@extends('admin.layout.main')
@section('title','Report By Revenue')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Data</li>
	</ol>
	<!-- <h1 style=" font-family: 'Open Sans', sans-serif; font-size: 50px; font-weight: 300; text-transform: uppercase;">About</h1> -->
</div>
<div class="row ml-1">
	@if (Session::has('message'))
	<p class="alert alert-success">{{ Session::get('message')}}</p> 
	@elseif(Session::has('err'))    
	<p class="alert alert-danger">{{ Session::get('err')}}</p>
	@endif
</div>
<div class="card">
	<div class="card-body ">
		<div class="col-md-6">
			<figure class="highcharts-figure">
				<div class="hichart" style="background: #fff">
					<select id="year" onchange="chartEvent()" style="margin: 20px 0px 0px 10px">              @foreach($arr_year as $year)
						<option value="{{$year}}" {!!$year ==  $year_now ? 'selected':'' !!}>{{$year}}</option>
						@endforeach
					</select>
					<div id="revenue_by_month">
					</div></div>

				</figure>
			</div>
			<div class="col-md-6">
				<figure class="highcharts-figure"> 
					<div class="hichart1" style="">  
						<div class="dontcare" style="background: #fff"><button style="margin: 18px 0px 0px 10px;background: #fff;border: 1px solid #fff;color:#fff">asds</button></div>                             
						<div id="revenue_by_year"></div>
					</div>
				</figure>
			</div>
		</div>
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="https://code.highcharts.com/modules/exporting.js"></script>
		<script src="https://code.highcharts.com/modules/export-data.js"></script>
		<script src="https://code.highcharts.com/modules/accessibility.js"></script>
		<script>
			$(window).load(function () {
				var year = new Date().getFullYear();
				$.ajax({
					dataType: "json",
					url: './chart?year='+year,
					success:function(data){    
						if(!data.status) {
							initChart(data);
						}
					}
				});            
			});
			function chartEvent(){
				var year = document.getElementById("year").value;
				$.ajax({
					dataType: "json",
					url: './chart?year='+year,
					success:function(data){    
						if(!data.status) {
							initChart(data);
						}
					}
				});
			}
			function initChart(result) {
				var data, options;
				data = {
					labels: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					series: [ {
						name: 'series-real',
						data: result,
					}]
				};
				options = {
					fullWidth: true,
					lineSmooth: false,
					height: "270px",
					low: 0,
					high: 'auto',
					series: {
						'series-projection': {
							showArea: true,
							showPoint: false,
							showLine: false
						},
					},
					axisX: {
						showGrid: false,

					},
					axisY: {
						showGrid: false,
						onlyInteger: true,
						offset: 0,
					},
					chartPadding: {
						left: 50,
						right: 20
					}
				};
				new Chartist.Line('#visits-trends-chart', data, options);
			};
		</script>
		<script>
			$(window).load(function () {
				var year = new Date().getFullYear();
				$.ajax({
					dataType: "json",
					url: './chart?year='+year,
					success:function(data){    
						if(!data.status) {
							initChart(data);
						}
					}
				});            
			});
			function chartEvent(){
				var year = document.getElementById("year").value;
				$.ajax({
					dataType: "json",
					url: './chart?year='+year,
					success:function(data){    
						if(!data.status) {
							initChart(data);
						}
					}
				});
			}
			function initChart(result) {
				Highcharts.chart('revenue_by_month', {
					chart: {
						type: 'line'
					},
					title: {
						text: 'Monthly Revenue'
					},
					xAxis: {
						categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
					},
					yAxis: {
						title: {
							text: 'Total'
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						},
					},
					series: [{
						name: 'Month',
						data: result
					}]
				});
			};

		</script>
		<script>
			$(window).load(function () {
				$.ajax({
					dataType: "json",
					url: './chart_by_year',
					success:function(data){    
						if(!data.status) {
							initChartByYear(data);
						}
					}
				});            
			});
			function initChartByYear(result){
				Highcharts.chart('revenue_by_year', {
					chart: {
						type: 'line'
					},
					title: {
						text: 'Year Revenue'
					},
					xAxis: {
						categories: result[0]
					},
					yAxis: {
						title: {
							text: 'Total'
						}
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: true
							},
							enableMouseTracking: false
						}
					},
					series: [{
						name: 'Year',
						data: result[1]
					}]
				});
			}    
		</script>
		@endsection
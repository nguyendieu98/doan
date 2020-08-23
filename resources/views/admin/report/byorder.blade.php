@extends('admin.layout.main')
@section('title','Report By Order')
@section('content')
{{ Html::script('https://code.jquery.com/jquery-3.1.1.min.js') }}
{{ Html::script('https://code.highcharts.com/highcharts.js') }}
{{ Html::script('https://code.highcharts.com/modules/exporting.js') }}
{{ Html::script('https://code.highcharts.com/modules/export-data.js') }}
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" >Report By Order</li> 
	</ol>
</div> 
<div class="card">
	<div class="card-body "> 
		<p class="h3 text-center">Order</p>
		<br>
		<form method="GET">
			<div class="form-group row col-md-12">			
				<label for="from" class="col-md-1">From: </label>
				<div class="col-md-3 form-group"><input type="text" class="form-control" id="from" name="from" readonly value="{{isset($_GET['from']) ? $_GET['from'] : ''}}" placeholder="From date"></div> 
				<label for="to" class="col-md-1">To: </label>
				<div class="col-md-3 form-group"><input type="text" class="form-control" id="to" name="to" readonly value="{{isset($_GET['to']) ? $_GET['to'] : ''}}" placeholder="To date"></div> 
				<div class="col-md-3 form-group">
					<input type="submit" class="btn" value="Sort" id="sort">
					<button type="button" class="btn btn-danger" id="clear" style="margin-left: 5px;">Clear</button>
				</div> 
			</div> 
		</form>
		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">Unconfimred</th>
						<th scope="col">Confimred</th>
						<th scope="col">Delivery</th>
						<th scope="col">Delivered</th>
						<th scope="col">Cancel</th>
						<th scope="col">Total Order</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{$unconfimred}}</td>
						<td>{{$confimred}}</td>
						<td>{{$delivery}}</td>
						<td>{{$delivered}}</td>
						<td>{{$cancel}}</td>
						<td>{{$unconfimred + $confimred + $delivery +$delivered + $cancel}}</td>
					</tr>  
				</tbody>
			</table>
			<p class="h4" style="font-weight: 600;">Revenue: {{number_format($total_amount)}}đ <span style="font-size: 15px;font-weight: normal;">(Order delivered)</span></p>
		</div>
		<div id="chartyear" class="form-group" data-order="{{ $orderYear }}"></div>
		<hr>
		<div class="form-group ">
			<form  method="GET" class="col-md-9">
				<?php $year = range(2019, strftime("%Y", time())); 
				$years = array();
				foreach (array_reverse($year) as $key => $value) {
					$years += array($value => $value);
				} 
				?>  
				<div class="col-md-2"><p class="h4 text-dark">Select year:</p></div>
				<div class="col-md-3">
					{{Form::select('year',$years,null,['class' => 'form-control','onchange'=>'this.form.submit()'])}}
				</div>
			</form>
		</div>
		<div id="container" class="form-group col-md-12" data-order="{{ $orderMonth }}"></div>
	</div>
</div>  
<script> 
	$(document).ready(function(){
		var orderbymonth = $('#container').data('order');
		var listOfValue = [];
		var listOfMonth = [];
		orderbymonth.forEach(function(element){
			listOfMonth.push(element.getMonth);
			listOfValue.push(element.value);
		});
		var chart = Highcharts.chart('container', { 
			title: {
				text: 'Order By Month'
			},

			subtitle: {
				text: ''
			},

			xAxis: {
				categories: listOfMonth,
			},

			series: [{
				type: 'column',
				colorByPoint: true,
				data: listOfValue,
				showInLegend: false
			}]
		});
	}); 
	$(document).ready(function(){
		var orderbyyear = $('#chartyear').data('order');
		var listOfValue1 = [];
		var listOfYear = [];
		orderbyyear.forEach(function(element){
			listOfYear.push(element.getYear);
			listOfValue1.push(element.value);
		});
		var chart2 = Highcharts.chart('chartyear', { 
			title: {
				text: 'Order By Year'
			},

			subtitle: {
				text: ''
			},

			xAxis: {
				categories: listOfYear,
			},

			series: [{
				type: 'column',
				colorByPoint: true,
				data: listOfValue1,
				showInLegend: false
			}]
		});
	});
	$( function() {
		var dateFormat = "mm/dd/yy",
		from = $( "#from" )
		.datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1
		})
		.on( "change", function() {
			to.datepicker( "option", "minDate", getDate( this ) ); 
		}),
		to = $( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1
		})
		.on( "change", function() {
			from.datepicker( "option", "maxDate", getDate( this ) );
		});

		function getDate( element ) {
			var date;
			try {
				date = $.datepicker.parseDate( dateFormat, element.value );
			} catch( error ) {
				date = null;
			}

			return date;
		} 
	}); 
	$("#clear").click(function(){
		$("#from").val('');
		$("#to").val('');
	});
	$("#sort").click(function(){
		var from = $("#from").val();
		var to = $("#to").val();
		if (!from) {
			document.getElementById("from").setAttribute("disabled", true);
		}
		if (!to) {
			document.getElementById("to").setAttribute("disabled", true);
		}  
		this.form.submit(); 
	});
</script>
@endsection
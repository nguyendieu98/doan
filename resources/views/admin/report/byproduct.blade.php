@extends('admin.layout.main')
@section('title','Report By Product')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" >Report By Product</li> 
	</ol>
</div> 
<div class="card">
	<div class="card-body ">
		<p class="h3 text-center">Product</p>
		<br>
		<form method="GET">
			<div class="form-group row col-md-12">			
				<label for="from" class="col-md-1">From: </label>
				<div class="col-md-3 form-group"><input type="text" class="form-control" id="from" name="from" readonly value="{{isset($_GET['from']) ? $_GET['from'] : ''}}" placeholder="From Date"></div> 
				<label for="to" class="col-md-1">To: </label>
				<div class="col-md-3 form-group"><input type="text" class="form-control" id="to" name="to" readonly value="{{isset($_GET['to']) ? $_GET['to'] : ''}}" placeholder="To Date"></div> 
				<div class="col-md-3 form-group">
					<input type="submit" class="btn" value="Sort" id="sort">
					<button type="button" class="btn btn-danger" id="clear" style="margin-left: 5px;">Clear</button>
				</div> 
			</div> 
		</form>
		<div class="form-group col-md-12">
			<p>Total product's quantity sold: {{$total_amount}}</p>
		</div>
		<div class="form-group">
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Product Name</th>
						<th scope="col">Quantity sold</th>
						<th scope="col">Quantity remaining</th>
					</tr>
				</thead>
				<tbody>
					@foreach($products as $key => $product)
					<tr>
						<th scope="row">{{$key+1}}</th>
						<td>{{ $product->name }}</td>
						<th class="text-center">{{ $quantity_sell[$product->id] }}</th>
						<th class="text-center">{{ $quantity_remaining[$key] }}</th>
					</tr> 
					@endforeach
				</tbody>
			</table>
		</div> 
	</div>
</div> 
<script>
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
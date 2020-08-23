@extends('admin.layout.main')
@section('title','Order')
@section('content') 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active" >Order</li>
	</ol>
</div>
<div class="row ml-1 col-md-12">
	@if (Session::has('message'))
	<p class="alert alert-success notification">{{ Session::get('message')}}</p> 
	@elseif(Session::has('err'))    
	<p class="alert alert-danger notification">{{ Session::get('err')}}</p>
	@endif
</div> 
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-2">
				<a href="{{route('order.create')}}" class="btn btn-outline-success mb-2 mt-2">Create New</a>
			</div>
			<form action="{{ route('order.index') }}" method="GET">
			<div class="col-md-7">
				<div class="form-group row col-md-12">			
					<label for="from" class="col-md-1">From: </label>
					<div class="col-md-4 form-group"><input type="text" class="form-control" id="from" name="from" readonly value="{{isset($_GET['from']) ? $_GET['from'] : ''}}"></div> 
					<label for="to" class="col-md-1">To: </label>
					<div class="col-md-4 form-group"><input type="text" class="form-control" id="to" name="to" readonly value="{{isset($_GET['to']) ? $_GET['to'] : ''}}"></div> 
					<div class="col-md-1 form-group">
						<input type="submit" class="btn" value="Sort" id="sort">
					</div> 
				</div> 
			</div>
			<div class="col-md-3">
				<div class="form-group"> 
					{{ Form::select('status', array('' => 'All status','unconfimred' => 'Unconfimred', 'confimred' => 'Confimred', 'delivery' => 'Delivery', 'delivered' => 'Delivered', 'cancel' => 'Cancel'),'',['class' => 'form-control orderstatus','id'=>'status'])}} 
				</div> 
			</div>
			</form>
		</div>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th >#</th>
					<th >Order code</th>
					<th>Total amount</th>
					<th>Status</th>
					<th>Payment</th>
					<th>Transaction date</th>
					<th>Username id</th>
					<th colspan="5">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach($orders as $key => $order)
					<tr>
						<td >{{ ++$key }}</td>
						<td >{{ $order->order_code }}</td>
						<td>{{number_format($order->total_amount)}}đ</td>
						@switch($order->status)
						@case('unconfimred')
						<td ><span class="label label-warning col-md-9 " style="font-size: 13px;" >{{$order->status}}</span></td>
						@break 
						@case('confimred')
						<td ><span class="label label-success col-md-9" style="font-size: 13px;" >{{$order->status}}</span></td>
						@break
						@case('cancel')
						<td ><span class="label label-danger col-md-9" style="font-size: 13px;" >{{$order->status}}</span></td>
						@break
						@case('delivery')
						<td ><span class="label label-info col-md-9" style="font-size: 13px;" >{{$order->status}}</span></td>
						@break
						@case('delivered')
						<td ><span class="label label-primary col-md-9" style="font-size: 13px;" >{{$order->status}}</span></td>
						@break          
						@default

						@endswitch
						<td>{{$order->payment}}</td>
						<td>{{date("m/d/Y", strtotime($order->transaction_date))}}</td>
						<td>
							@if($order->user_id)
							{{$order->user->username}}
							@else
							At store
							@endif
						</td>
						<td colspan="5">
							<button type="button" class=" btn btn-light text-info orderdetail" style="width:40px; padding: 4px 5px;" data-toggle="modal" data-target="#orderinfo" value="{{$order->id}}"> 
								<i class="fas fa-info-circle" style="font-size: 18px;"></i>  
							</button>
							@if($order->status != 'cancel' && $order->status != 'delivered')
							<a href="{{route('order.edit',$order->id)}}" class="ml-1 btn" style="width:40px; padding: 5px;background: #f0f0f0;"><i class="fa fa-edit "></i></a>
							@endif
						</td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
	<!-- paginate -->
		<div class="">
			{{$orders->links()}}	
		</div>
</div>
<!-- Modal detail -->
<div class="modal fade bd-example-modal-lg" id="orderinfo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<span class="h4">Order detail</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="height: 320px; overflow-x: auto; overflow-y: auto;">
				<div class="custom-file form-group row">
					<div class="col-md-12"> 
						<table class="table table-hover">
							<thead>
								<tr>
									<th style="width: 5%;">#</th>
									<th style="width: 50%;">Product</th>
									<th style="width: 10%;">Size</th>
									<th style="width: 10%;">Color</th>
									<th style="width: 10%;">Quantity</th>
									<th style="width: 10%;">Price</th>
								</tr>
							</thead>
							<tbody class="listorder"> 
							</tbody>
						</table>
					</div> 
				</div> 
				<div class="col-md-12 row"> 
					<div class="col-md-7">
						<h4>User information:</h4>
						<hr style="margin: 0;">
						<div class="userinfo"></div>
					</div>
					<div class="col-md-5">
						<p>Total amount: <b><span class="total_amount"></span></b></p>
						<p>Note: <span class="notes"></span></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary " data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){  
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});  
		$(".orderdetail").click(function(){
			var id = $(this).val();
			const formatter = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'VND' })
			$.ajax({
				type: 'POST',
				url: '{{ URL::to('get_order_detail') }}',
				data: {
					id: id
				},
				dataType: 'JSON',
				success:function(data){     
					var list = '';
					var total_amount = 0;
					var userinfo = '<p>Fullname: '+data.users.first_name+' '+data.users.last_name+'</p><p>Phone: '+data.users.phone+'</p><p>Email: '+data.users.email+'</p><p>Address: '+data.users.address+'</p>';
					for (var i = 0; i < data.names.length; i++) {
						list += '<tr><td>'+(i+1)+'</td><td>'+(data.names[i].name)+'</td><td>'+data.product_details[i].size+'</td><td>'+data.product_details[i].color+'</td><td>'+data.order_details[i].quantity+'</td><td>'+formatter.format(data.order_details[i].price)+'</td></tr>'; 
						total_amount += data.order_details[i].quantity * data.order_details[i].price;
					} 
					$(".listorder").html(list);
					$(".total_amount").html(formatter.format(total_amount));
					$(".notes").html(data.orders.notes);
					if (data.users) {
						userinfo += '<p>Payment: <b>'+data.orders.payment+'</b></p>';
						$(".userinfo").html(userinfo);
					}else{
						$(".userinfo").html('<p>Buy at the store!</p>');
					}
				}
			});
		});
	});
	$('.orderstatus').change(function(){
		if (!$(this).val()) {
			document.getElementById("status").setAttribute("disabled", true);
		}
		this.form.submit();
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
	$("#status").change(function(){
		@if(!isset($_GET['from']))
			document.getElementById("from").setAttribute("disabled", true);
		@endif
		@if(!isset($_GET['to']))
			document.getElementById("to").setAttribute("disabled", true);
		@endif
		this.form.submit();
	}); 
	$("#sort").click(function(){
		var status = $("#status").val();
		var from = $("#from").val();
		var to = $("#to").val();
		if (!status) {
			document.getElementById("status").setAttribute("disabled", true);
		} 
		if (!from) {
			document.getElementById("from").setAttribute("disabled", true);
		}
		if (!to) {
			document.getElementById("to").setAttribute("disabled", true);
		}  
		if (!status && !from && !to) {
			return false;
		} 
	});
</script>
@endsection
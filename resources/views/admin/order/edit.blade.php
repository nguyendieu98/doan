@extends('admin.layout.main')
@section('title','Edit Order')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active" >Edit Order</li>
	</ol>
</div>
<div class="card row"> 
	{{ Form::model($order,['route' => ['order.update',$order->id],'method' => 'put']) }}
	<div class="col-md-6">
		<ul class="list-group list-group-flush">
			<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Order code: </span>
				<div class="col-md-8">{{$order->order_code}}</div>
			</li>
			<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Total amount: </span>
				<div class="col-md-8">{{number_format($order->total_amount)}}đ</div>
			</li>
			<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Transaction date: </span>
				<div class="col-md-8">{{$order->transaction_date}}</div>
			</li> 
			<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Payment: </span>
				<div class="col-md-8">{{$order->payment}}</div>
			</li> 
			<li class="list-group-item" style="height: 75px;"><span class="col-md-4">Status:</span>
				<div class="col-md-8">
					{{ Form::select('status', array('unconfimred' => 'Unconfimred', 'confimred' => 'Confimred', 'delivery' => 'Delivery', 'delivered' => 'Delivered', 'cancel' => 'Cancel'),$order->status,['class' => 'form-control'])}}
				</div>
			</li>
		</ul>
	</div>
	<div class="col-md-6">
		<li class="list-group-item" style="height: 60px;"><span class="col-md-4">User: </span>
			<div class="col-md-8">{{$order->user->username}}</div>
		</li>
		<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Address: </span>
			<div class="col-md-8">{{$order->user->address}}</div>
		</li>
		<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Email: </span>
			<div class="col-md-8">{{$order->user->email}}</div>
		</li>  
		<li class="list-group-item" style="height: 60px;"><span class="col-md-4">Phone: </span>
			<div class="col-md-8">{{$order->user->phone}}</div>
		</li> 
		<li class="list-group-item"  id="noteli">
			<span class="col-md-4">Notes: </span>
			<div class="col-md-8" id="note" >{{$order->notes}}</div>
		</li>   
	</div>
	<div class="col-md-12" style="margin-top: 5px;">
		{{ Form::submit('Update',['class'=>'btn btn-success update']) }}
		<a class="btn btn-danger" href="{{route('order.index')}}">Back</a>
	</div> 
	{{ Form::close() }}  
</div>
<script>
var note = $("#note").height();
$("#noteli").height(note);
@if(!$order->notes)
$("#noteli").height('38px');
@endif
</script>
@endsection
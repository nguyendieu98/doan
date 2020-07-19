@extends('admin.layout.main')
@section('title','Edit Order')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active" >Edit Order</li>
	</ol>
</div>
<div class="card">
	{{ Form::model($order,['route' => ['order.update',$order->id],'method' => 'put']) }}
  	<ul class="list-group list-group-flush">
	    <li class="list-group-item" style="height: 60px;"><span class="col-md-2">Order code: </span>
	    	<div class="col-md-4">{{$order->order_code}}</div>
	    </li>
	    <li class="list-group-item" style="height: 60px;"><span class="col-md-2">Total amount: </span>
	    	<div class="col-md-4">${{$order->total_amount}}</div>
	    </li>
	    <li class="list-group-item" style="height: 60px;"><span class="col-md-2">Transaction date: </span>
	    	<div class="col-md-4">{{$order->transaction_date}}</div>
	    </li>
	    <li class="list-group-item" style="height: 70px;"><span class="col-md-2">Status</span>
	    	<div class="col-md-4">
	    		{{ Form::select('status', array('unconfimred' => 'Unconfimred', 'confimred' => 'Confimred', 'delivery' => 'Delivery', 'delivered' => 'Delivered', 'cancel' => 'Cancel'),$order->status,['class' => 'form-control'])}}
	    	</div>
	    </li>
  	</ul>
  	{{ Form::submit('Update',['class'=>'btn btn-success update']) }}
	<a class="btn btn-danger" href="{{route('order.index')}}">Back</a>
	{{ Form::close() }}  
</div>
@endsection
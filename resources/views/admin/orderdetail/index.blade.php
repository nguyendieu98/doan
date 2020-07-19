@extends('admin.layout.main')
@section('title','Order Detail')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Order Detail</li>
	</ol>
</div>
<div class="card">
	<div class="card-body "> 
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th >#</th>
					<th >Order id</th>
					<th >Product</th>
					<th >Size</th>
					<th >Color</th>
					<th >Quantity</th>
					<th >Price</th> 
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach($order_details as $key => $order_detail)
					<tr>
						<td >{{ ++$key }}</td>
						<td>{{$order_detail->order_id}}</td>
						<td>{{$order_detail->product_detail->product->name}}</td> 
						<td>{{$order_detail->product_detail->size}}</td> 
						<td>{{$order_detail->product_detail->color}}</td> 
						<td>{{$order_detail->quantity}}</td>
						<td>{{$order_detail->price}}</td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endsection
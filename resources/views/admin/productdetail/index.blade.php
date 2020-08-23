@extends('admin.layout.main')
@section('title','Product Detail')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Product Detail</li>
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
	<div class="card-body ">
		<div class="row">
			<div class="col-md-9"> 
			</div>
			<div class="col-md-3"> 	
				{{ Form::open(['route' => ['productdetail.index' ],'method' => 'get']) }}
					{{ Form::text('name','',['class'=>'form-control ','style'=>'float: left','placeholder'=>'Search Name']) }}
				{{ Form::close() }}	
			</div>
		</div>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th >#</th>
					<th >Product</th>
					<th >Size</th>
					<th >Color</th>
					<th >Price</th>
					<th colspan="5">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach($product_details as $key => $product_detail)
					<tr>
						<td >{{ ++$key }}</td>
						<td>{{$product_detail->product->name}}</td> 
						<td>{{$product_detail->size}}</td>
						<td>{{$product_detail->color}}</td>
						<td>{{number_format($product_detail->product->price)}}đ</td>
						<td colspan="5">
							<!-- Button trigger modal -->
							<!-- Tạo data-id để chưa giá trị id -->
							<button type="button" class="fas fa-trash-alt deleteUser text-danger btn" data-id="{{$product_detail->id}}" data-toggle="modal" data-target="#Modal" style="width: 40px; padding: 7px 5px;">
							</button>
						</td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
		<!-- paginate -->
		<div class="">
			{{$product_details->links()}}	
		</div>
	</div>
</div>
{{Form::open(['route' => 'product_detail_delete_modal', 'method' => 'POST', 'class'=>'col-md-5'])}}
{{ method_field('DELETE') }}
{{ csrf_field() }}
<!-- Modal -->
@include('admin.Modal.delete')
@endsection
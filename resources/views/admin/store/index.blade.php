@extends('admin.layout.main')
@section('title','Store')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Store</li>
	</ol>
</div>
@include('admin.modal.addquantity')
<div class="row ml-1">
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
				<a href="{{route('store.create')}}" class="btn btn-outline-success mb-2 mt-2">Create New</a>
			</div>
			<div class="col-md-3">
				{{ Form::open(['route' => ['store.index' ],'method' => 'get']) }}
					{{ Form::text('name','',['class'=>'form-control ','style'=>'float: left','placeholder'=>'Search Name']) }}
				{{ Form::close() }}
			</div>
		</div>
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>#</th>
					<th>Product</th>
					<th>Size</th>
					<th>Color</th>
					<th>Quantity</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach($stores as $key => $store)
					<tr>
						<td >{{ ++$key }}</td>
						<td>{{$store->product_detail->product->name}}</td>
						<td>{{$store->product_detail->size}}</td>
						<td>{{$store->product_detail->color}}</td>
						<td>{{$store->quantity}}</td>
						<td><a href="{{route('store.edit',$store->id)}}" class="ml-1 btn" style="width:40px; padding: 5px;"><i class="fa fa-edit "></i></a>
							<button type="button" class="fas fa-trash-alt deleteUser text-danger btn" data-id="{{$store->id}}" data-toggle="modal" data-target="#Modal" style="width: 40px; padding: 7px 5px;">
							</button></td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
		<!-- paginate -->
		<div class="">
			{{$stores->links()}}	
		</div>
	</div>	
</div>
{{Form::open(['route' => 'store_delete_modal', 'method' => 'POST', 'class'=>'col-md-5'])}}
{{ method_field('DELETE') }}
{{ csrf_field() }}
<!-- Modal -->
@include('admin.Modal.delete')
{{ Form::close() }}
<script type="text/javascript">
	$('select#product').change(function(){
		var product_id = $(this).val();
		$('select#color').html('<option value="">Select color</option>');
		$('#quantity').val('0');
		$.ajax({
			type: 'get',
			url: '{{ URL::to('get_list_size') }}',
			data: {
				product_id: product_id
			},
			success:function(data){
				var option = '<option value="">Select size</option>';
				for (const property in data) {
					option += '<option value="'+`${data[property]}`+'">'+`${data[property]}`+'</option>';
				}
				$('select#size').html(option);
			}
		});
	});
	$('select#size').change(function(){
		var product_id = $('#product').val();
		var size = $(this).val();
		$('#quantity').val('0');
		$.ajax({
			type: 'get',
			url: '{{ URL::to('get_list_color') }}',
			data: {
				product_id: product_id,
				size: size
			},
			success:function(data){
				var option = '<option value="">Select color</option>';
				for (const property in data) {
					option += '<option value="'+`${data[property]}`+'">'+`${data[property]}`+'</option>';
				}
				$('select#color').html(option);
			}
		});
	});
	$('select#color').change(function(){
		var product_id = $('#product').val();
		var size = $('#size').val();
		var color = $(this).val();
		if (color) {
			$.ajax({
				type: 'get',
				url: '{{ URL::to('get_quantity') }}',
				data: {
					product_id: product_id,
					size: size,
					color: color
				},
				success:function(data){
					$('#quantity').val(data);
				}
			});
		}else{
			$('#quantity').val('0');
		}
	});
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
	$('#save').click(function(){
		var result = true;
		var product = $('#product').val();
		var size = $('#size').val();
		var color = $('#color').val();
		var quantity = $('#quantity').val();
		if (!product) {
			result = false;
			$('#producterr').html("Please select product.");
		}else{
			$('#producterr').html("");
		}
		if (!size) {
			result = false;
			$('#sizeerr').html("Please select size.");
		}else{
			$('#sizeerr').html("");
		}
		if (!color) {
			result = false;
			$('#colorerr').html("Please select color.");
		}else{
			$('#colorerr').html("");
		}
		if (!quantity) {
			result = false;
			$('#quantityerr').html("Please enter quantity.");
		}else{
			$('#quantityerr').html("");
		}
		return result;
	});
</script>
@endsection
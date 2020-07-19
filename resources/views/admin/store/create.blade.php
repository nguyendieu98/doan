@extends('admin.layout.main')
@section('title','Create Store')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('store.index')}}" title="Danh mục">Store</a></li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
</div>
<div class="card">
	<div class="card-body">	
		{{ Form::open(['url' => 'admin/store', 'method' => 'post']) }}
		<div class="form-group row">
			<div class="col-md-5">
				{{Form::label('Product:')}}
				{{Form::select('product_id',$products,null,['class' => 'form-control','placeholder'=>'Select product','id'=>'product'])}}
				<span id="producterr" class="text-danger"></span>
			</div>
			<div class="col-md-2">
				{{Form::label('Size:')}}
				{{Form::select('size',array(''=>'Select size'),null,['class' => 'form-control','id'=>'size'])}}
				<span id="sizeerr" class="text-danger"></span>
			</div>
			<div class="col-md-2">
				{{Form::label('Color:')}}
				{{Form::select('color',array(''=>'Select color'),null,['class' => 'form-control','id'=>'color'])}}
				<span id="colorerr" class="text-danger"></span>
			</div>
			<div class="col-md-2">
				{{Form::label('Quantity available:')}}
				{{Form::number('quantity',0,['class' => 'form-control','min'=>'1','max'=>'10000','id'=>'quantity'])}}
				@if ($errors->has('quantity'))
				<div class="text-danger">{{ $errors->first('quantity') }}</div>
				@endif
			</div>
		</div>
		<div class="form-group row col-md-12">
			{{ Form::submit('Save',['class'=>'btn btn-success','id'=>'save']) }}
			<a class="btn btn-danger" href="{{route('store.index')}}">Back</a>
		</div>
		{{ Form::close() }}
	</div>
</div>
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
		return result;
	});
</script>			
@endsection
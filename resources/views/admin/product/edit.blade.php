@extends('admin.layout.main')
@section('title','Edit Product')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('product.index')}}" title="Sản phẩm">Product</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>
</div>
<div class="row ml-1 col-md-12">
	@if (Session::has('message'))
	<p class="alert alert-success">{{ Session::get('message')}}</p> 
	@elseif(Session::has('err'))    
	<p class="alert alert-danger">{{ Session::get('err')}}</p>
	@endif
</div>
<div class="card">
	<div class="card-body ">
		{{Form::model($product,['route' => ['product.update',$product->id],'method' => 'put','enctype '=>'multipart/form-data'])}}
		<div class="row form-group">
			<div class="col-md-8">
				<div class="form-group">
					<h3 class="text-center">Product</h3>
				</div>
				<div class="form-group row">
					<input type="hidden" name="id" value="{{$product->id}}" id="productdetailid">
					<div class="col-md-9">
						{{ Form::label('name','Name : ')}}
						{{ Form::text('name',$product->name,['class'=>'form-control'])}}
						<span class="text-danger">{{ $errors->first('name')}}</span>
					</div>
					<div class="col-md-3">
						{{ Form::label('Isdisplay:','',['class'=>'']) }}
						{{ Form::select('isdisplay', array('1' => 'Display', '0' => 'Hidden'),$product->isdisplay,['class' => 'form-control'])}} 
					</div> 
				</div>
				<div class="form-group">
					{{ Form::label('Description','Description : ')}}
					<br>
					{{ Form::textarea('description',$product->description,['id'=>'editor'])}}
					<br>
					<span class="text-danger">{{ $errors->first('description')}}</span>
				</div>
				<div class="form-group">
					{{ Form::label('Image:') }} <br/>
					{{ Form::file('imagee',['class' => 'form-control', 'id' => 'filename']) }}
					{{ Form::hidden('image', $product->image, ['class' => 'form-control','id' => 'image_file' ]) }}
					<p id="path">{{ $product->image }}</p>
					<span class="text-danger">{{ $errors->first('image')}}<br> </span>
				</div>
				<div class="form-group row">
					<div class="col-md-6">
						{{ Form::label('price','Price : ')}}
						{{ Form::number('price',$product->price,['class'=>'form-control'])}}
						<span class="text-danger">{{ $errors->first('price')}}</span>
					</div>
					<div class="col-md-6">
						{{ Form::label('promotion','Promotion : ')}}
						{{ Form::number('promotion',$product->promotion,['class'=>'form-control','min'=>'0', 'max'=>'99'])}}
						<span class="text-danger">{{ $errors->first('promotion')}}</span>
					</div> 
				</div> 
				<div class="form-group row">
					<div class="col-md-6">
						{{Form::label('Brand:')}}
						{{Form::select('brand_id',$brand,$product->brand_id,['class' => " form-control",'placeholder'=>'Choose a manufacturer'])}}
						@if ($errors->has('brand_id'))
						<div class="text-danger">{{ $errors->first('brand_id') }}</div>
						@endif
					</div>
					<div class="col-md-6">
						{{Form::label('Category:')}}
						{{Form::select('category_id',$category,$product->category_id,['class' => " form-control",'placeholder'=>'Choose a category'])}}
						@if ($errors->has('category_id'))
						<div class="text-danger">{{ $errors->first('category_id') }}</div>
						@endif
					</div> 
				</div> 
				<input type="hidden" name="selectsize" value="123" >
			</div>
			<div class="col-md-4">
				<div class="form-group" >
					<h3 class="text-center">Size & Color</h3>
					<div style="overflow-x: auto; height: 250px;">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>STT</th>
									<th>Size</th>
									<th>Color</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								@foreach($product_details as $key => $product_detail)
								<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $product_detail->size }}</td>
									<td>{{ $product_detail->color }}</td>
									<td><button type="button" class="fas fa-trash-alt deleteUser text-danger btn" data-id="{{$product_detail->id}}" data-toggle="modal" data-target="#Modal" style="width: 40px; padding: 2px 5px;">
									</button></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group">
					<div class=" form-group col-md-12">
						{{ Form::label('Size: ')}}
						{{ Form::select('size[]', array('36' => '36','37' => '37','38' => '38','39' => '39','40' => '40','41' => '41','42' => '42','43' => '43'),null, ['class'=>'form-control size','multiple']) }}
					</div>
					<div class="col-md-12">
						<!-- <button type="button" class="btn btn-success col-md-12" id="choosecolor" ><b>Click to Choose Color</b></button> -->
						<span id="colorerr" class="text-danger"></span>
					</div>
					<span id="colorerr" class="text-danger"></span>
					<div class="row sizebox form-group" style="overflow-x: auto; height: 250px;">
						<h4 class="text-center">Choose Color:</h4>
						<span id="selectcolor"></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			{{ Form::submit('Update',['class'=>'btn btn-success update']) }}
			<a class="btn btn-danger" href="{{route('product.index')}}">Back</a>
		</div>
		{{ Form::close() }}
	</div>
</div> 
{{Form::open(['route' => 'product_detail_delete_modal', 'method' => 'POST', 'class'=>'col-md-5'])}}
{{ method_field('DELETE') }}
{{ csrf_field() }}
<!-- Modal -->
@include('admin.Modal.delete')
{{ Form::close() }}
<script type="text/javascript">
	$('#filename').on('change',function(e){  
		var filenames = document.getElementById('filename'); 
		if (filenames.files.length > 1) {
			var fname = '';
			for (var i = 0; i <= filenames.files.length - 1; i++) {
				fname += filenames.files.item(i).name+',';
			}   
			fname = fname.slice(0,fname.length-1);
			document.getElementById("image_file").value = fname;
			$("#path").html(fname);
		}else{
			value = $(this).val();	
			$.ajax({
				type: 'get',
				url: '{{ URL::to('setvalue') }}',
				data: {
					value: value
				},
				success:function(data){
					document.getElementById("image_file").value = data;
					$("#path").html(data);
				}
			});
		}
	});
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
	$(document).ready(function() {
		$('.size').select2();
	    //$('.color').select2();
	});
	$(".size").change(function(){
		$('.sizebox').html('<h4 class="text-center">Choose Color:</h4><span id="selectcolor"></span>');
		var sizes = $(".size").val();
		if (!sizes) {
			alert('Please choose a size!');
		}else{ 
			for (var i = 0; i < sizes.length; i++) { 
				var colors = ['black', 'white', 'blue', 'yellow', 'gray', 'green', 'red', 'pink'];
				size = sizes[i];
				key = i;
				id = $('#productdetailid').val();	
				$.ajax({
					async: false,
					type: 'get',
					url: '{{ URL::to('getcolor') }}',
					data: {
						size: sizes[i],
						id: id
					},
					success:function(data){
						color = '';
						for (var i = 0; i < data.length; i++) { 
							pos = colors.indexOf(data[i].color);
							if (pos != -1) {
								colors.splice(pos, 1);
							} 
						}
						for (var j = 0; j < colors.length; j++) {
							color +='<option value="'+colors[j]+'">'+colors[j].toUpperCase()+'</option>' ;
						}
						$('#selectcolor').append('<div class="col-md-12 form-group"><div class="col-md-3"><input type="text" value="'+size+'" class=" form-control" style="width:100%;"></div>	<div class="col-md-9"><select id="color'+key+'" name="color'+key+'[]" class="form-control col-md-12 color" multiple style="width: 100%;">'+color+'</select></div></div>'); 
					}
				});
			}
			$('.color').select2();
		}
	});
	$('.update').click(function(){
		var sizes = $(".size").val();
		var result = true;
		if (sizes) {
			for (var i = 0; i < sizes.length; i++) {
				var changecolor = $('#color'+i).val()
				if (!changecolor) {
					$('#colorerr').html("Please choose color.");
					result = false;
				}
			}
		}
		return result;
	});
</script>
@endsection
@extends('admin.layout.main')
@section('title','Create Order')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('order.index')}}" title="Danh mục">Order</a></li>
		<li class="breadcrumb-item active">Create</li>
	</ol>
</div>
<div class="card">
	<div class="card-body row">
		{{ Form::open(['url' => 'admin/order', 'method' => 'post']) }}
		<div class="col-md-6">
			<div class="form-group col-md-12">
				{{ Form::label('product_code','Product code : ')}}
				{{ Form::text('product_code',uniqid(),['class'=>'form-control col-md-8', 'readonly'=>'readonly'])}}
			</div>
			<div class="form-group col-md-12">
				{{ Form::label('notes','Notes : ')}}
				<br>
				{{ Form::textarea('description','',['class'=>'col-md-12','rows'=>'4','placeholder'=>'Notes about your order.'])}}
				<br>
			</div>		
			<div class="form-group col-md-12">
				{{ Form::submit('Save',['class'=>'btn btn-success', 'id'=>'save']) }}
				<a class="btn btn-danger" href="{{route('order.index')}}">Back</a>
			</div>
		</div>
		<div class="col-md-6 row">
			<div class="form-group">
				<div class="col-md-9"> 
					<label>Select product:</label>
					<select name="product_detail_id[]" class="form-control selectproduct product0" id="first" onchange="setquantity($(this).val(),'max0')">
						<option value="">Select product</option>
						@foreach($product_details as $key => $product_detail)
						<option value="{{$product_detail->id}}">{{$product_detail->product->name}}. {{$product_detail->size}}.   {{$product_detail->color}}</option>
						@endforeach 
					</select> 
					<span class="producterr0 text-danger"></span>
				</div>
				<div class="col-md-3 row">
					<label class="">Quantity:(<span class="max0 text-danger"></span>)</label>
					<input type="number" class="quantity quantity0" name="quantity[]" min="1" max="100" value="1" style="width: 55px;">
				</div>
			</div> 
			<button type="button" class="btn btn-success" id="add" style="float: right;">Add Product</button>
			<span class="text-danger producterr" style="margin-left: 3%"></span>
		</div>
		{{ Form::close() }}
	</div>
</div>
<script>
	$(document).ready(function(){  
		var i=0;  
		$('#add').click(function(){  
			i++;
			var max = 'max'+i;
			max = "'"+max+"'";  
			$('#add').before('<div class="form-group" id="row'+i+'"><div class="col-md-9"><label>Select product:</label><select name="product_detail_id[]" class="form-control selectproduct product'+i+'" onchange="setquantity($(this).val(),'+max+')"></select><span class="producterr'+i+' text-danger"></span></div><div class="col-md-3 row"><label>Quantity:(<span class="max'+i+' text-danger"></span>)</label><input type="number" class="quantity quantity'+i+'" name="quantity[]" min="1" max="100" value="1" style="width: 55px;"><button type="button" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div>'); 
			var listproduct = $("#first").html();
			$("select.product"+i).html(listproduct);
			$('.selectproduct').select2();
		});  
		$(document).on('click', '.btn_remove', function(){  
			var button_id = $(this).attr("id");   
			$('#row'+button_id+'').remove();  
		});  
	}); 
	$(document).ready(function() {
		$('.selectproduct').select2();
	});
	$("#save").click(function(){
		var result = true;
		var name = document.getElementsByName("product_detail_id[]");
		var quantity = document.getElementsByName("quantity");
		var list = [];
		$('.producterr'+i).html("");
		for (var i = 0; i < name.length; i++) {
			var selectname = $('.product'+i).val();
			var selectquantity = $('.quantity'+i).val();
			list.push(name[i].value);
			$('.producterr'+i).html("");
			$(".producterr").html("");
			if (!selectname) {
				$('.producterr'+i).html("Please select Product and Quantity.");
				result = false;
			}
			if (!selectquantity) {
				$('.producterr'+i).html("Please select Product and Quantity.");
				result = false;
			}
		}
		for (var i = 0; i < list.length; i++) {
			if (list.indexOf(list[i]) != list.lastIndexOf(list[i])) {
				$(".producterr").html("Duplicate products.");
				result = false;
			}
		}
		return result;
	}); 
	function setquantity(product_detail_id,max) {
		if (product_detail_id) {
			$.ajax({
				type: 'get',
				url: '{{ URL::to('get_quantity_order') }}',
				data: {
					product_detail_id: product_detail_id,
				},
				success:function(data){ 
					$('.'+max).html(data);
					var quantity = max.slice(max.length-1);
					$('.quantity'+quantity).attr({"max" : data});
				}
			});
		}else{
			$('.'+max).html('');
		}
	}
</script>
<style>
	.btn_remove{
		padding: 3px 10px;
		float: right;
	}
	.quantity {
		padding: 3px 0px 3px 10px;
		border: 1px solid #aaa;
		border-radius: 3px ;
		margin-bottom: 10px;
	}
</style>
@endsection
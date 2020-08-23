@extends('admin.layout.main')
@section('title','Product')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.css" />
 
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Product</li>
	</ol>
</div> 
<div class='notifications top-left'></div>
<div class="row ml-1 col-md-12">
	@if (Session::has('message'))
	<p class="alert alert-success notification">{{ Session::get('message')}}</p> 
	@elseif(Session::has('err'))    
	<p class="alert alert-danger notification">{{ Session::get('err')}}</p>
	@endif
</div>
<div class="card">
	<div class="card-body col-md-12">
		<div class="row"> 
			<div class="col-md-6">
				<a href="{{route('product.create')}}" class="btn btn-outline-success mb-2 mt-2">Create New</a>
			</div> 
			<form action="{{ route('product.index') }}" method="GET" onsubmit="return sort();">
				<div class="col-md-3">
					<div class="form-group"> 
						{{ Form::text('name','',['class'=>'form-control ','id'=>'search','style'=>'float: left','placeholder'=>'Search Name']) }} 
					</div>
				</div>
				<div class="col-md-3">
					{{Form::select('category',$categories,'',['class' => 'form-control','id'=>'category', 'placeholder'=>'Choose a category'])}}
				</div>
			</form>
		</div>
		<table class="table table-striped table-sm">
			<thead class="">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Product code</th>
					<th scope="col">Name</th>
					<th scope="col">Image</th>
					<th scope="col">Price</th>
					<th scope="col">IsDisplay</th>
					<th >Action</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					@foreach($products as $key => $product)
					<tr>
						<td class="">{{ ++$key }}</td>
						<td class="">{{ $product->product_code }}</td>
						<td class="" width="400"><a href="{{route('product.show',$product->id)}}" style="text-decoration: none;color: black;">
							{{ $product->name }}</a>
						</td> 
						<td><img src="{{ asset('images/'.$product->image) }}" width="50" height="50"></img></td>
						<td class="">{{number_format($product->price)}}đ</td>
						@if($product->isdisplay)
						<td><span class="label label-success" style="font-size: 13px;">Display</span></td>
						@else
						<td><span class="label label-danger" style="font-size: 13px;">Hidden</span></td>
						@endif
						<td colspan="5">
							<!-- Button trigger modal -->
							<!-- Tạo data-id để chưa giá trị id -->
							<button type="button" class="fas fa-trash-alt deleteUser text-danger btn" data-id="{{$product->id}}" data-toggle="modal" data-target="#Modal" style="width: 40px; padding: 8px 5px;">
							</button>
							<a href="{{route('product.edit',$product->id)}}" class="ml-1 btn btn-secondary" style="width:40px; padding: 5px;background: #f0f0f0;"><i class="fa fa-edit "></i></a> 
							<button type="button" class=" btn text-info modalimage" style="width:40px; padding: 4px 5px;" data-toggle="modal" data-target="#listimage" value="{{$product->id}}"> 
								<i class="far fa-images" style="font-size: 18px;"></i> 
							</button>
						</td>
					</tr>
					@endforeach
				</tr>
			</tbody>
		</table>
		<!-- paginate -->
		<div class="">
			{{$products->links()}}	
		</div>
	</div>
</div>
<input type="hidden" id="product_id">
<!-- Modal upload image -->
<form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="uploadform"> 
	@csrf
	<div class="modal fade bd-example-modal-lg" id="listimage" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content" >
				<div class="modal-header">
					<span class="h4">Choose list images</span>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="height: 400px; overflow-x: auto; overflow-y: auto;">
					<div class="custom-file form-group row">
						<div class="col-md-3">
							<input type="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01" id="filename2" name="filename2">
						</div>
						<div class="col-md-3">
							<img id="image_preview_container" src="" style="width: 100%; max-height: 150px;">
						</div> 
						<div class="col-md-4">
							<input type="submit" id="sub" class="btn btn-primary" value="Upload"> 
						</div> 
					</div>
					<div class="form-group row listimages">
						<span id="begin"></span>  
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary " data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
</form>
{{Form::open(['route' => 'product_delete_modal', 'method' => 'POST', 'class'=>'col-md-5'])}}
{{ method_field('DELETE') }}
{{ csrf_field() }}
<!-- Modal -->
@include('admin.Modal.delete')
{{ Form::close() }}
<script>
	$(document).ready(function(){  
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}); 
		var i = 0;
		$(".modalimage").click(function(){
			var id = $(this).val();
			$("#product_id").val(id);
			var imagename = '{{ asset('images/')}}';
			$.ajax({
				type: 'POST',
				url: '{{ URL::to('get_list_image') }}',
				data: {
					product_id: id
				},
				dataType: 'JSON',
				success:function(data){
					var imagevalue ='<span id="begin"></span>';
					for (var k = 0; k < data.lists.length; k++) {
						i++;
						imagevalue += '<div class="form-group col-md-3 row'+i+'"><img src="'+imagename+'/'+data.lists[k]+'" alt="" style="height: 150px; width: 100%;"><p class="text-center" style="margin-top: 5px;"><button type="button" class="text-danger btn fas fa-trash-alt remove" onclick="remove('+i+','+data.ids[k]+');"></button></p></div>';
					}
					$('.listimages').html(imagevalue);
				}
			});
		});
		$('#filename2').on('change', function (event, label) { 
			var checkImage = $(this).val();
	        var ext = checkImage.substring(checkImage.lastIndexOf('.') + 1).toLowerCase();
	        if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg"){
	        	let reader = new FileReader();
            	reader.onload = (e) => { 
              		$('#image_preview_container').attr('src', e.target.result); 
            	} 
            	reader.readAsDataURL(this.files[0]);  
	        } 
			
		}); 
		$('#uploadform').submit(function(e) {
			e.preventDefault();
			var formData = new FormData(this); 
			var nameimage = $("#filename2").val();
			var product_id = $("#product_id").val();
			var addimage = true;
			$.ajax({
				type: 'POST',
				async: false,
				url: '{{ URL::to('save_image') }}',
				data: {
					nameimage: nameimage,
					product_id: product_id
				},
				success:function(data){
					if (data == '0') {
						addimage = false;
					}else{
						addimage = data;
						notify('Create success!');
					}
				}
			});
			if (addimage) {
				$.ajax({
					type:'POST',
					url: "{{ url('move_image')}}",
					data: formData,
					cache:false,
					contentType: false,
					processData: false,
					success: (data) => {
						this.reset(); 
						var filename = '{{ asset('images/')}}'; 
						$("#begin").after('<div class="form-group col-md-3 row'+i+'"><img src="'+filename+'/'+data+'"style="height: 150px; width:100%;"><p class="text-center"><button type="button" class="text-danger btn fas fa-trash-alt  remove" id="'+i+'" onclick="remove('+i+','+addimage+');" style="padding: 5px 15px; margin-top:5px;"></button></p></div>');
						$(".afterlist").after('<input type="hidden" name="listimage[]" value="'+data+'" class="image'+i+'">');
					} 
				});
			}else{
				alert('Image already exists!');
			}
			$('#image_preview_container').attr('src',''); 
		});    
	});
	function remove(i,id) { 
		if (confirm("Delete this image!")) { 
			$.ajax({
				type: 'POST', 
				url: '{{ URL::to('delete_image') }}',
				data: {
					id: id 
				},
				success:function(data){ 
					notify('Delete success!');
				}
			});
			$('.row'+i).remove();  
		}   
	}  
	$("#sub").click(function(){
		var checkImage = $("#filename2").val();
        var ext = checkImage.substring(checkImage.lastIndexOf('.') + 1).toLowerCase();
        if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg"){
        	return true;
        }else{
        	alert('Please change image.'+ext);
        	return false;
        }
	}); 
	function notify(message) {
		$.notify(message, "success");
	}
	$("#category").change(function(){
		@if(!isset($_GET['name'])) 
			document.getElementById("search").setAttribute("disabled", true); 
		@else
			@if ($_GET['name'] == '')
			document.getElementById("search").setAttribute("disabled", true); 
			@endif
		@endif
		this.form.submit();
	}); 
	function sort() {
		document.getElementById("category").setAttribute("disabled", true);
	}
</script>
@endsection
@extends('admin.layout.main')
@section('title','Product Sale')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.css" />
 
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item active">Product Sale</li>
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
							<a href="{{route('product.edit',$product->id)}}" class="ml-1 btn btn-secondary" style="width:40px; padding: 5px;background: #f0f0f0;"><i class="fa fa-edit "></i></a>  
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

@endsection
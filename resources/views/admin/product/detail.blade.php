@extends('admin.layout.main')
@section('title','Detail Product')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('product.index')}}" title="Danh mục">product</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
</div>
<div class="card">
	<div class="card-body col-md-12">
		<p><b>Name : </b>{{$product->name}}</p>
		<p ><b>Description : </b>{!! $product->description !!}</p>
		<?php  $images = explode(',',$product->image);	?>
		<p ><b>Image : </b>
			@foreach($images as $key => $image)
			<img src="{{ asset('images/'.$image) }}" width="150" height="100"></img>
			@endforeach
		</p>
		<p><b>Price : </b>{{number_format($product->price)}}đ</p>
		<p><b>Quantity : </b></p>
		<p><b>Promotion : </b>{{$product->promotion}}%</p>
		<p><b>Brand : </b>{{$product->brand->name}}</p>
		<p><b>Category : </b>{{$product->category->name}}</p>
	</div>
</div>
@endsection
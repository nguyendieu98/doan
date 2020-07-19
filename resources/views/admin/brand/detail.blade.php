@extends('admin.layout.main')
@section('title','Detal Brand')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/admin/home">Admin</a></li>
		<li class="breadcrumb-item" ><a href="{{route('brand.index')}}" title="Danh mục">Brand</a></li>
		<li class="breadcrumb-item active">Detail</li>
	</ol>
</div>
<div class="card">
	<div class="card-body col-md-12">
		<p><b>Name : </b>{{$brand->name}}</p>
		<p><b>Description : </b>{!! $brand->description !!}</p>
		<p><b>Created at : </b>{{$brand->created_at}}</p>
		<p><b>Updated at : </b>{{$brand->updated_at}}</p>
	</div>
</div>
@endsection
